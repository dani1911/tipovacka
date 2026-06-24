<?php

namespace App\Traits;

use App\Models\Game;
use App\Models\GameAdvancement;
use App\Models\GamePrediction;

trait HandlesBracketAdvancement
{
    private function advanceBracket(Game|GamePrediction $entry): void
    {
        $entry instanceof GamePrediction ? $entry->loadMissing('game.stage') : null;

        $stage = $entry instanceof Game ? $entry->stage : $entry->game->stage;

        if (!$entry->wasChanged('winner_team_id') || !$stage->isKnockout()) {
            return;
        }

        $gameId = $entry instanceof Game ? $entry->id : $entry->game_id;
    
        GameAdvancement::where('source_game_id', $gameId)->get()->each(function (GameAdvancement $advancement) use ($entry) {
            $teamId = match ($advancement->result) {
                'winner' => $entry->winner_team_id,
                'loser'  => $entry->getLoser(),
            };

            if ($entry instanceof Game) {
                $advancement->destinationGame->update([$advancement->destination_position => $teamId]);
                // dd($advancement);
            } else {
                GamePrediction::where('user_id', $entry->user_id)
                    ->where('game_id', $advancement->destination_game_id)
                    ->update([$advancement->destination_position => $teamId]);
            }
        });
    }
}