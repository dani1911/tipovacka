<?php

namespace App\Observer;

use App\Models\Game;
use App\Models\GameAdvancement;

class GameObserver
{
    public function updated(Game $game): void
    {
        if (!$game->isDirty('winner_team_id')) {
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