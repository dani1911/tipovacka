<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::today();

        $games = Game::with('homeTeam')->with('awayTeam')->withSum('gamePredictions', 'points')->whereDate('game_date', $today)->get();

        $users = DB::select('SELECT id, name, sum(points) AS points
                        FROM (
                        SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN game_predictions ON users.id=game_predictions.user_id GROUP BY users.id, users.name
                        UNION ALL
                        SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN stage_predictions ON users.id=stage_predictions.user_id GROUP BY users.id, users.name) u
                        GROUP BY id, name ORDER BY points DESC LIMIT 3');

        return view('home', ['games' => $games, 'title' => 'Dnešné zápasy', 'date_format' => 'H:i', 'users' => $users]);
    }
}
