<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\Stage;
use App\Models\GamePrediction;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display the games from group stage.
     */
    public function index()
    {
        $games = Game::with('homeTeam')->with('awayTeam')->withCount(['gamePredictions as points' => function($query) { $query->where('points', '>', 0); }])->whereIn('stage_id', [1,2,3,4,5,6])->orderBy('game_date')->get();

        return view('games', ['games' => $games, 'title' => 'Všetky zápasy', 'date_format' => 'd. m. Y H:i']);
    }

    /**
     * Display the games from playoffs stage.
     */
    public function playoffs()
    {
        $games = Game::with('homeTeam')->with('awayTeam')->withCount(['gamePredictions as points' => function($query) { $query->where('points', '>', 0); }])->whereIn('stage_id', [7,8,9,11])->orderBy('id')->get();
        $stages = Stage::whereIn('id', [7,8,9,11])->get();

        return view('playoffs', ['games' => $games, 'stages' => $stages, 'title' => 'Pavúk', 'date_format' => 'd. m. Y H:i']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::get();
        $stages = Stage::get();

        return view('_partials.game.add', ['teams' => $teams, 'stages' => $stages]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_game = new Game();

        $new_game->game_date = $request->input('game_date');
        $new_game->home_team_id = $request->input('home_team');
        $new_game->away_team_id = $request->input('away_team');
        $new_game->stage_id = $request->input('stage_id');

        $new_game->save();

        return redirect()->back()->with('status', 'Game ' . $new_game->id . ' added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $game = Game::with('homeTeam')->with('awayTeam')
                    ->with('gamePredictions.user')
                    ->findOrFail($id);

        $teams = Team::get();

        return view('game', ['game' => $game, 'teams' => $teams]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $ht_goals = $request->input('home_team_goals');
        $at_goals = $request->input('away_team_goals');
        $advancing_team = $request->input('advancing_team');
        
        $game = Game::find($id);

        if (null !== $request->input('home_team') && null !== $request->input('away_team'))
        {
            $game->home_team_id = $request->input('home_team');
            $game->away_team_id = $request->input('away_team');
        }

        if (null !== $ht_goals && null !== $at_goals)
        {
            $game->home_team_goals = $ht_goals;
            $game->away_team_goals = $at_goals;
            $game->advancing_team_id = $advancing_team;
            $predictions = GamePrediction::where('game_id', '=', $id)->get();
    
            foreach ($predictions as $prediction)
            {   
                $pred = new PredictionController($prediction->id);
                // dd($prediction);
                $pred->updateGame($prediction, $ht_goals, $at_goals, $game->stage_id, $advancing_team);
            }
        }

        $game->save();

        return redirect()->back();
    }
}
