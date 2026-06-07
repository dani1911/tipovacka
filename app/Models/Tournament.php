<?php

namespace App\Models;

use App\Enums\Type;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[Fillable(['name', 'abbreviation', 'logo', 'slug', 'is_active', 'type', 'start_date', 'end_date'])]
#[WithoutTimestamps]
#[Table(dateFormat: 'Y-m-d')]
class Tournament extends Model
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
            'type' => Type::class,
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Gets the stages that are part of the tournament.
     */
    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }

    /**
     * Gets the games that are part of the tournament.
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    /**
     * Gets the rulesets that apply to the tournament.
     */
    public function rulesets(): HasMany
    {
        return $this->hasMany(Ruleset::class);
    }

    /**
     * Gets the stage teams that are part of the tournament.
     */
    public function stageTeams(): HasMany
    {
        return $this->hasMany(StageTeam::class);
    }

    /**
     * Gets the game predictions that were made for the tournament.
     */
    public function gamePredictions(): HasManyThrough
    {
        return $this->hasManyThrough(GamePrediction::class, Game::class);
    }

    /**
     * Gets the stage predictions that were made for the tournament.
     */
    public function stagePredictions(): HasManyThrough
    {
        return $this->hasManyThrough(StagePrediction::class, Stage::class);
    }

    /**
     * Gets the active tournament.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
