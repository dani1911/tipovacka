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
    public function updateGame(int $ht_goals, int $at_goals, int $id)
    {
        $game_pred = GamePrediction::where('game_id', '=', $id)->firstOrFail();

        $point = 0;
        if ($game_pred->home_team_goals === $ht_goals && $game_pred->away_team_goals === $at_goals)
            $point = 1;

        $game_pred->points = $point;
        $game_pred->update();
    }
}
