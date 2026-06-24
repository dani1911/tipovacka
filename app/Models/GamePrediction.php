<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['game_id', 'user_id', 'home_team_id', 'away_team_id', 'home_team_score', 'away_team_score', 'winner_team_id', 'points'])]
class GamePrediction extends Model
{
    use HasFactory;

    /**
     * Gets the game for the prediction is for.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Gets the user who made the prediction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Gets the home team for the game.
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Gets the away team for the game.
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    /**
     * Gets the team that the user predicted to win.
     */
    public function winnerTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }

    /**
     * Returns the game score formatted with colon in-between
     */
    protected function colonScore(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->home_team_score !== null && $this->away_team_score !== null
                ? "{$this->home_team_score} : {$this->away_team_score}"
                : null
        );
    }

    /**
     * Gets the points amassed by the user for the prediction.
     */
    public function scopeEarned($query)
    {
        return $query->whereNotNull('points')->where('points', '>', 0);
    }

    /**
     * Determines if the prediction score is correct.
     */
    protected function isCorrect(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->game->home_team_score !== null
                && $this->game->home_team_score === $this->home_team_score
                && $this->game->away_team_score === $this->away_team_score
        );
    }

    /**
     * Determines if the knockout prediction is correct.
     */
    protected function areTeamsCorrect(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->home_team_id !== null
                && $this->game->home_team_id === $this->home_team_id
                && $this->game->away_team_id === $this->away_team_id
        );
    }

    /**
     * Sets the game winning team based on predicted score.
     */
    protected static function booted(): void
    {
        $callback = function (GamePrediction $prediction) {
            $prediction->winner_team_id = match(true) {
                !empty($prediction->winner_team_id) => $prediction->winner_team_id,
                $prediction->home_team_score > $prediction->away_team_score => $prediction->game->home_team_id,
                $prediction->away_team_score > $prediction->home_team_score => $prediction->game->away_team_id,
                default => null
            };
        };

        static::creating($callback);
        static::updating($callback);
    }
}
