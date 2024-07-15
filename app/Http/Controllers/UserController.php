<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stage = ' IN (7,8,9,11)';

        $users = DB::select('SELECT id, name, sum(points) AS points
                        FROM (
                        SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN game_predictions ON users.id=game_predictions.user_id LEFT JOIN games ON game_predictions.game_id=games.id WHERE games.stage_id ' . $stage . ' GROUP BY users.id, users.name
                        UNION ALL
                        SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN stage_predictions ON users.id=stage_predictions.user_id WHERE stage_predictions.stage_id ' . $stage . ' GROUP BY users.id, users.name) u
                        WHERE points IS NOT NULL GROUP BY id, name ORDER BY points DESC');

        return view('standings', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stage = ' IN (7,8,9,11)';

        $stage_predictions = User::with(['stagePredictions' => function($query) use ($stage) { $query->whereRaw('stage_id' . $stage); }])->findOrFail($id);
        $game_predictions = DB::select('SELECT u.id, u.name, gp.game_id AS gpgid, gp.home_team_goals AS gphg, gp.away_team_goals AS gpag, g.home_team_goals AS ghg, g.away_team_goals AS gag, gp.game_id as gpgi, g.game_date, htm.abbreviation AS htabb, htm.name AS htname, atm.abbreviation AS atabb, atm.name AS atname
                            FROM game_predictions gp
                            LEFT JOIN users u ON u.id = gp.user_id
                            LEFT JOIN games g ON gp.game_id = g.id
                            LEFT JOIN teams htm ON g.home_team_id = htm.id
                            LEFT JOIN teams atm ON g.away_team_id = atm.id
                            WHERE u.id = ' . $id . ' AND g.stage_id ' . $stage . ' ORDER BY g.game_date ASC');

        $user = $this->getUser($id, $stage);

        return view('user', ['user' => $user, 'stage_predictions' => $stage_predictions, 'game_predictions' => $game_predictions, 'date_format' => 'd. m. Y H:i']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('_partials.user.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_name = $request->input('user_name');

        $new_user = new User();

        $new_user->name = $user_name;
        $new_user->email = strtolower(preg_replace('/\s+/', '',$user_name)) . '@email.cc';
        $new_user->password = Hash::make($user_name);

        $new_user->save();

        return redirect()->back()->with('status', 'User ' . $new_user->id . ' added!');
    }

    public function ajaxChangeStandingsContent(Request $request)
    {
        ($request->stage === 'round1') ? $stage = ' IN (1,2,3,4,5,6,10)' : $stage = ' IN (7,8,9,11)';

        $users = DB::select('SELECT id, name, sum(points) AS points
                FROM (
                SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN game_predictions ON users.id=game_predictions.user_id LEFT JOIN games ON game_predictions.game_id=games.id WHERE games.stage_id ' . $stage . ' GROUP BY users.id, users.name
                UNION ALL
                SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN stage_predictions ON users.id=stage_predictions.user_id WHERE stage_predictions.stage_id ' . $stage . ' GROUP BY users.id, users.name) u
                WHERE points IS NOT NULL GROUP BY id, name ORDER BY points DESC');

        $html = view('_partials.standings.table', compact('users'))->render();

        return response()->json(['status' => true, 'html' => $html]);
    }

    /**
     * Display the specified resource.
     */
    public function ajaxChangePageContent(Request $request)
    {
        $id = $request->id;
        ($request->stage === 'round1') ? $stage = ' IN (1,2,3,4,5,6,10)' : $stage = ' IN (7,8,9,11)';

        $game_predictions = DB::select('SELECT u.id, u.name, gp.game_id AS gpgid, gp.home_team_goals AS gphg, gp.away_team_goals AS gpag, g.home_team_goals AS ghg, g.away_team_goals AS gag, gp.game_id as gpgi, g.game_date, htm.abbreviation AS htabb, htm.name AS htname, atm.abbreviation AS atabb, atm.name AS atname
                            FROM game_predictions gp
                            LEFT JOIN users u ON u.id = gp.user_id
                            LEFT JOIN games g ON gp.game_id = g.id
                            LEFT JOIN teams htm ON g.home_team_id = htm.id
                            LEFT JOIN teams atm ON g.away_team_id = atm.id
                            WHERE u.id = ' . $id . ' AND g.stage_id ' . $stage . 'ORDER BY g.game_date ASC');
        $stage_predictions = User::with(['stagePredictions' => function($query) use ($stage) { $query->whereRaw('stage_id' . $stage); } ])->findOrFail($id);

        $user = $this->getUser($id, $stage);

        $html = view('_partials.user.stats', ['user' => $user, 'stage_predictions' => $stage_predictions, 'game_predictions' => $game_predictions, 'date_format' => 'd. m. Y H:i'])->render();

        return response()->json(['status' => true, 'html' => $html]);
    }

    protected function getUser($id, $stage)
    {
        $user = DB::select('SELECT id, name, sum(points) AS points
                        FROM (
                        SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN game_predictions ON users.id=game_predictions.user_id LEFT JOIN games ON game_predictions.game_id=games.id WHERE games.stage_id ' . $stage . ' GROUP BY users.id, users.name
                        UNION ALL
                        SELECT users.id, users.name, sum(points) AS points FROM users LEFT JOIN stage_predictions ON users.id=stage_predictions.user_id WHERE stage_predictions.stage_id ' . $stage . ' GROUP BY users.id, users.name) u
                        where id = ' . $id . ' group by id, name');

        (empty($user)) ? $user = (object) ['id' => $id, 'name' => 'none', 'points' => 'NA'] : $user = $user[0];

        return $user;
    }
}
