<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GamePrediction;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::select('select id, name, sum(points) as points
                        from (
                        select users.id, users.name, sum(points) as points from users left join game_predictions on users.id=game_predictions.user_id left join games on game_predictions.game_id=games.id where games.stage_id < 7 group by users.id, users.name
                        union all
                        select users.id, users.name, sum(points) as points from users left join stage_predictions on users.id=stage_predictions.user_id group by users.id, users.name) u
                        group by id, name order by points desc');

        return view('standings', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user_predictions = User::with('stagePredictions.team')->findOrFail($id);

        $user = DB::select('select id, name, sum(points) as points
                        from (
                        select users.id, users.name, sum(points) as points from users left join game_predictions on users.id=game_predictions.user_id left join games on game_predictions.game_id=games.id where games.stage_id < 7 group by users.id, users.name
                        union all
                        select users.id, users.name, sum(points) as points from users left join stage_predictions on users.id=stage_predictions.user_id group by users.id, users.name) u
                        where id = ' . $id . ' group by id, name');

        return view('user', ['user' => $user[0], 'user_predictions' => $user_predictions, 'date_format' => 'd. m. Y H:i']);
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
}
