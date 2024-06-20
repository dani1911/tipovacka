<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\GamePrediction;
use Illuminate\Http\Request;

class GamePredictionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::get();
        $games = Game::with('homeTeam')->with('awayTeam')->orderByDesc('id')->get();

        return view('_partials.predictions.add', ['users' => $users, 'games' => $games]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $new_prediction = new GamePrediction();

        $new_prediction->user_id = $request->input('user_id');
        $new_prediction->game_id = $request->input('game_id');
        $new_prediction->home_team_goals = $request->input('home_team_goals');
        $new_prediction->away_team_goals = $request->input('away_team_goals');

        $new_prediction->save();

        return redirect()->back()->with('status', 'Prediction ' . $new_prediction->id . ' added!');
    }
}
