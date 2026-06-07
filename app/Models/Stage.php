<?php

namespace App\Models;

use App\Enums\Phase;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Translatable\Attributes\Translatable;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'abbreviation', 'phase', 'tournament_id'])]
#[WithoutTimestamps]
#[Translatable('name')]
class Stage extends Model
{
    use HasFactory, HasTranslations;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'phase' => Phase::class,
        ];
    }

    /**
     * Gets the tournament that the stage is part of.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Gets the games that are part of the tournament's stage.
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    /**
     * Gets the stage teams that are part of the tournament's stage.
     */
    public function stageTeams(): HasMany
    {
        return $this->hasMany(StageTeam::class);
    }

    /**
     * Gets the predictions that were made for the tournament's stage.
     */
    public function stagePredictions(): HasMany
    {
        return $this->hasMany(StagePrediction::class);
    }

    /**
     * Gets the winners of the tournament's stage.
     */
    public function stageWinners(): HasMany
    {
        return $this->hasMany(StageWinner::class);
    }

    /**
     * Gets the ruleset for the tournament's stage.
     */
    public function ruleset(): HasOne
    {
        return $this->hasOne(Ruleset::class);
    }
}
