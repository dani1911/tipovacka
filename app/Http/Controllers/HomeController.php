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

        $games = Game::with('homeTeam')->with('awayTeam')->withCount(['gamePredictions as points' => function($query) { $query->where('points', '>', 0); }])->whereDate('game_date', $today)->orderBY('game_date')->get();

        $stage = '> 6';

        $users = DB::select('SELECT id, name, sum(points) AS points
                        FROM (
                        SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN game_predictions ON users.id=game_predictions.user_id LEFT JOIN games ON game_predictions.game_id=games.id WHERE games.stage_id ' . $stage . ' GROUP BY users.id, users.name
                        UNION ALL
                        SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN stage_predictions ON users.id=stage_predictions.user_id WHERE stage_predictions.stage_id ' . $stage . ' GROUP BY users.id, users.name) u
                        WHERE points IS NOT NULL GROUP BY id, name ORDER BY points DESC LIMIT 3');

        return view('home', ['games' => $games, 'title' => 'Dnešné zápasy', 'date_format' => 'H:i', 'users' => $users]);
    }

    public function ajaxChangeStandingsContent(Request $request)
    {
        ($request->stage === 'round1') ? $stage = '< 7' : $stage = '> 6';

        $users = DB::select('SELECT id, name, sum(points) AS points
                FROM (
                SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN game_predictions ON users.id=game_predictions.user_id LEFT JOIN games ON game_predictions.game_id=games.id WHERE games.stage_id ' . $stage . ' GROUP BY users.id, users.name
                UNION ALL
                SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN stage_predictions ON users.id=stage_predictions.user_id WHERE stage_predictions.stage_id ' . $stage . ' GROUP BY users.id, users.name) u
                WHERE points IS NOT NULL GROUP BY id, name ORDER BY points DESC LIMIT 3');

        $html = view('_partials.standings.table', compact('users'))->render();

        return response()->json(['status' => true, 'html' => $html]);
    }
}
