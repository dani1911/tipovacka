<?php

namespace App\Observer;

use App\Enums\Phase;
use App\Models\StagePrediction;
use App\Models\StageWinner;

class StageWinnerObserver
{
    /**
     * Handle the StageWinner "created" event.
     */
    public function created(StageWinner $stageWinner): void
    {
        $this->handlePoints($stageWinner);
    }

    /**
     * Handle the StageWinner "updated" event.
     */
    public function updated(StageWinner $stageWinner): void
    {
        if (!$stageWinner->wasChanged(['tournament_id', 'stage_id', 'team_id'])) {
            return;
        }

        $this->handlePoints($stageWinner);
    }

    /**
     * Awards points for correct predictions as set in the stage ruleset.
     */
    private function handlePoints(StageWinner $stageWinner)
    {
        $ruleset = $stageWinner->tournament->rulesets
            ->where('phase', $stageWinner->stage->phase->rulesetPhase())
            ->first();
        
        $stagePredictions = StagePrediction::where('tournament_id', $stageWinner->tournament_id)
            ->where('stage_id', $stageWinner->stage_id)
            ->get();

        foreach ($stagePredictions as $prediction) {
            $points = 0;

            if($prediction->team_id === $stageWinner->team_id) {
                if ($prediction->stage->phase === Phase::GROUP) {
                    $points += $ruleset->points_group_winner;
                } elseif ($prediction->stage->phase === Phase::FINAL) {
                    $points += $ruleset->points_tournament_winner;
                }
            }

            $prediction->update(compact('points'));
        }
    }
}