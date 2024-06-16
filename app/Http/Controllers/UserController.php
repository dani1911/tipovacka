<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::select('select id, name, sum(points) as points
                        from (
                        select users.id, users.name, sum(points) as points from users left join game_predictions on users.id=game_predictions.user_id group by users.id, users.name
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
                        select users.id, users.name, sum(points) as points from users left join game_predictions on users.id=game_predictions.user_id group by users.id, users.name
                        union all
                        select users.id, users.name, sum(points) as points from users left join stage_predictions on users.id=stage_predictions.user_id group by users.id, users.name) u
                        where id = ' . $id . ' group by id, name');

        return view('user', ['user' => $user[0], 'user_predictions' => $user_predictions, 'date_format' => 'd. m. Y H:i']);
    }
}
