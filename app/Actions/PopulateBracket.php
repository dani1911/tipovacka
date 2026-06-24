<?php

namespace App\Actions;

use App\Enums\Phase;
use App\Models\Game;
use App\Models\GamePrediction;
use App\Models\Tournament;

class PopulateBracket
{
    public function handle(Tournament $tournament, int $userId): ?string
    {
        $hasBracket = GamePrediction::where('user_id', $userId)
            ->whereHas('game', fn($q) => $q->where('tournament_id', $tournament->id))
            ->whereHas('game.stage', fn($q) => $q->where('phase', Phase::KNOCKOUT))
            ->exists();

        if ($hasBracket) {
            return 'already_exists';
        }

        $hasDeadlinePassed = $tournament->rulesets
            ->where('phase', Phase::KNOCKOUT)
            ->first()
            ?->hasDeadlinePassed() ?? false;

        if ($hasDeadlinePassed) {
            return 'deadline_passed';
        }

        $games = Game::whereHas('stage', fn($q) => $q->whereIn('phase', Phase::knockoutPhases()))
            ->where('tournament_id', $tournament->id)
            ->get();

        if ($games->isEmpty()) {
            return 'no_games';
        }

        $now = now();

        $predictions = $games->map(fn(Game $game) => [
            'game_id' => $game->id,
            'user_id' => $userId,
            'home_team_id' => $game->home_team_id,
            'away_team_id' => $game->away_team_id,
            'home_team_score' => null,
            'away_team_score' => null,
            'winner_team_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        GamePrediction::insert($predictions);

        return null;
    }
}