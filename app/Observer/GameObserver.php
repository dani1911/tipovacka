<?php

namespace App\Observer;

use App\Models\Game;
use App\Models\GameAdvancement;
use App\Models\GamePrediction;

class GameObserver
{
    /**
     * Handle the Game "updated" event.
     */
    public function updated(Game $game): void
    {
        $this->handlePoints($game);
        $this->handleAdvancements($game);
    }

    /**
     * Awards points for correct predictions as set in the stage ruleset.
     */
    private function handlePoints(Game $game): void
    {
        if (!$game->wasChanged(['home_team_score', 'away_team_score', 'winner_team_id'])) {
            return;
        }

        if ($game->home_team_score === null || $game->away_team_score === null) {
            return;
        }

        $ruleset = $game->tournament->rulesets
            ->where('phase', $game->stage->phase->rulesetPhase())
            ->first();

        if (!$ruleset) {
            return;
        }

        $game->gamePredictions->each(function (GamePrediction $prediction) use ($game, $ruleset) {
            $points = 0;

            if ($prediction->isCorrect) {
                $points += $ruleset->points_exact_score;
            }

            if ($prediction->winner_team_id === $game->winner_team_id) {
                $points += $ruleset->points_match_winner;
            }

            $prediction->update(compact('points'));
        });
    }

    /**
     * Handles advancing team to next game in knockout stage.
     */
    private function handleAdvancements(Game $game): void
    {
        if (!$game->wasChanged('winner_team_id') || !$game->stage->isKnockout()) {
            return;
        }

        $game->advancements->each(function (GameAdvancement $advancement) use ($game) {
            $teamId = match ($advancement->result) {
                'winner' => $game->winner_team_id,
                'loser'  => $game->getLoser(),
            };

            $advancement->destinationGame->update([
                $advancement->destination_position => $teamId,
            ]);
        });
    }
}