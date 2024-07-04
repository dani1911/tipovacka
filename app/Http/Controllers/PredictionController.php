<?php

namespace App\Http\Controllers;

class PredictionController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function updateGame($prediction, int $ht_goals, int $at_goals, int $stage, $advancing_team_id)
    {
        $point_game = $point_adv = 0;

        if ($ht_goals === $prediction->home_team_goals && $at_goals === $prediction->away_team_goals)
        {
            (in_array($stage, [1,2,3,4,5,6])) ? $point_game = 1 : $point_game = 2;
        }

        if (null !== $advancing_team_id && $prediction->advancing_team_id == $advancing_team_id)
        {
            ($stage === 10) ? $point_adv = 4 : $point_adv = 1;
        }

        $prediction->points = $point_game + $point_adv;
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
