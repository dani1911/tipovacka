<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StageWinner;
use App\Models\StagePrediction;
use App\Models\User;
use App\Models\Team;

class StageController extends Controller
{
    public function index()
    {
        $users = User::with('stagePredictions.team')->orderBy('name')->get();
        $winners = StageWinner::with('team')->get();

        return view('stage', ['users' => $users, 'stage_winners' => $winners]);
    }

    public function edit()
    {
        $teams = Team::get();
        return view('_partials/stage/edit', ['teams' => $teams]);
    }

    public function store(Request $request)
    {
        $winners = [
            1 => $request->input('group_a'),
            2 => $request->input('group_b'),
            3 => $request->input('group_c'),
            4 => $request->input('group_d'),
            5 => $request->input('group_e'),
            6 => $request->input('group_f'),
            7 => $request->input('final'),
        ];

        foreach ($winners as $key => $value)
        {
            if (null !== $value)
            {
                $winner = new StageWinner();
                $winner->stage = $key;
                $winner->team_id = $value;
                $winner->save();
    
                $predictions = StagePrediction::where('stage', '=', $key)->get();
    
                foreach ($predictions as $prediction)
                {
                    $pred = new PredictionController($prediction->id);
                    $pred->updateStage($prediction, $key, $value);
                }
            }
        }

        return redirect()->back();
    }
}
