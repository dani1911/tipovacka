<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::today();

        $games = Game::with('homeTeam')->with('awayTeam')->withSum('gamePredictions', 'points')->whereDate('game_date', $today)->get();
        
        return view('games', ['games' => $games, 'title' => 'Dnešné zápasy', 'date_format' => 'H:i']);
    }
}
