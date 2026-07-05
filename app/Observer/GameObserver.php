<?php

namespace App\Observer;

use App\Enums\Phase;
use App\Models\Game;
use App\Models\GamePrediction;
use App\Models\StageTeam;
use App\Traits\HandlesBracketAdvancement;

class GameObserver
{
    use HandlesBracketAdvancement;

    /**
     * Handle the Game "updated" event.
     */
    public function updated(Game $game): void
    {
        $this->handlePoints($game);
        $this->advanceBracket($game);
        $this->createStageTeam($game);
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
     * Creates a next stage team for the winning team of the game.
     */
    private function createStageTeam(Game $game)
    {
        if (
            $game->stage->phase !== Phase::KNOCKOUT ||
            !$game->wasChanged('winner_team_id') ||
            !$game->winner_team_id
        ) {
            return;
        }

        $destinationGame = $game->advancements
            ->where('result', 'winner')
            ->first()
            ?->destinationGame;

        if (!$destinationGame) {
            return;
        }

        StageTeam::updateOrCreate(
            [
                'tournament_id' => $game->tournament_id,
                'stage_id' => $destinationGame->stage_id,
            ],
            [
                'team_id' => $game->winner_team_id,
            ]
        );
    }
}