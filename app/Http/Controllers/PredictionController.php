<?php

namespace App\Http\Controllers;

use App\Models\GamePrediction;
use App\Models\StagePrediction;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function updateGame($prediction, int $ht_goals, int $at_goals)
    {
        $point = 0;

        if ($ht_goals === $prediction->home_team_goals && $at_goals === $prediction->away_team_goals)
        {
            $point = 1;
        }

        $prediction->points = $point;
        $prediction->save();
    }

    public function updateStage($prediction, int $stage, int $team)
    {
        $point = 0;

        if ($prediction->stage_id === $stage && $prediction->team_id === $team)
        {
            $point = 1;
        }

        $prediction->points = $point;
        $prediction->save();
    }
}
