<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\GamePrediction;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::with('homeTeam')->with('awayTeam')->withSum('gamePredictions', 'points')->orderBy('game_date')->get();

        return view('games', ['games' => $games, 'title' => 'Všetky zápasy', 'date_format' => 'd. m. Y H:i']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = Team::get();

        return view('_partials.game.add', ['teams' => $teams]);
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

        return view('game', ['game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $ht_goals = $request->input('home_team_goals');
        $at_goals = $request->input('away_team_goals');
        
        $game = Game::find($id);
        $game->home_team_goals = $ht_goals;
        $game->away_team_goals = $at_goals;
        $game->save();

        $predictions = GamePrediction::where('game_id', '=', $id)->get();

        foreach ($predictions as $prediction)
        {   
            $pred = new PredictionController($prediction->id);
            $pred->updateGame($prediction, $ht_goals, $at_goals);
        }

        return redirect()->back();
    }
}
