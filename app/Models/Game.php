<?php

namespace App\Models;

use App\Models\Configuration;
use App\Models\GameAdvancement;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['tournament_id', 'game_number', 'stage_id', 'home_team_id', 'away_team_id', 'home_team_score', 'away_team_score', 'winner_team_id', 'game_time'])]
#[WithoutTimestamps]
class Game extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'game_time' => 'datetime',
        ];
    }

    /**
     * Gets the tournament that the game belongs to.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Gets the stage that the game belongs to.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
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
     * Gets the winner team for the game.
     */
    public function winnerTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }

    /**
     * Gets the advancements
     */
    public function advancements(): HasMany
    {
        return $this->hasMany(GameAdvancement::class, 'source_game_id');
    }

    public function incomingAdvancements(): HasMany
    {
        return $this->hasMany(GameAdvancement::class, 'destination_game_id');
    }

    /**
     * Gets the user predictions for the game.
     */
    public function gamePredictions(): HasMany
    {
        return $this->hasMany(GamePrediction::class);
    }

    /**
     * Gets the user prediction for the game.
     */
    public function userPrediction(): HasOne
    {
        return $this->hasOne(GamePrediction::class)
            ->where('user_id', auth()->id());
    }

    /**
     * Gets the games by the current phase.
     */
    public function scopeByCurrentPhase($query)
    {
        $currentPhase = Configuration::get('CURRENT_PHASE') ?? 'group';

        return $query->whereHas('stage', fn ($q) => $q->where('phase', $currentPhase));
    }

    /**
     * Gets the id for the losing team.
     */
    public function getLoser(): ?int
    {
        if (!$this->winner_team_id) return null;

        return $this->winner_team_id === $this->home_team_id
            ? $this->away_team_id
            : $this->home_team_id;
    }

    /**
     * Returns the game team formatted with dash in-between
     */
    protected function gameTeams(): Attribute
    {
        $homeTeamName = isset($this->homeTeam->name) ? "{$this->homeTeam->name}" : "TBD";
        $awayTeamName = isset($this->awayTeam->name) ? "{$this->awayTeam->name}" : "TBD";

        return Attribute::make(
            get: fn() => $homeTeamName . ' - ' . $awayTeamName
        );
    }

    /**
     * Returns the game score formatted with colon in-between
     */
    protected function colonScore(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->hasScore()
                ? "{$this->home_team_score} : {$this->away_team_score}"
                : null
        );
    }

    /**
     * Checks if the game has score assigned to it.
     */
    public function hasScore(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->home_team_score !== null && $this->away_team_score !== null
        );
    }

    /**
     * Checks if the deadline for making predictions has passed.
     */
    public function hasDeadlinePassed(): bool
    {
        return $this->tournament->rulesets
            ->where('phase', $this->stage->phase)
            ->first()
            ?->hasDeadlinePassed() ?? false;
    }
}
