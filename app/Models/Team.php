<?php

namespace App\Models;

use App\Enums\Type;
use App\Models\Club;
use App\Models\NationalTeam;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['type'])]
#[WithoutTimestamps]
class Team extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'type' => Type::class,
    ];

    /**
     * Gets the stage teams that are part of the tournament's stage.
     */
    public function stageTeams(): HasMany
    {
        return $this->hasMany(StageTeam::class);
    }

    /**
     * Gets the stage predictions that are for the team.
     */
    public function stagePredictions(): HasMany
    {
        return $this->hasMany(StagePrediction::class);
    }

    /**
     * Gets the stage winners that are for the team.
     */
    public function stageWinners(): HasMany
    {
        return $this->hasMany(StageWinner::class);
    }

    /**
     * Gets the club that the team belongs to.
     */
    public function club(): HasOne
    {
        return $this->hasOne(Club::class);
    }

    /**
     * Gets the national team that the team belongs to.
     */
    public function nationalTeam(): HasOne
    {
        return $this->hasOne(NationalTeam::class);
    }

    /**
     * Returns the team name based on tournament type.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->type) {
                Type::CLUB => $this->club?->name,
                Type::NATION => $this->nationalTeam?->country?->name,
            }
        );
    }

    /**
     * Returns the team image for game-box view based on tournament type.
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->type) {
                Type::CLUB => $this->club?->logo,
                Type::NATION => $this->nationalTeam?->country?->flag,
            }
        );
    }

    /**
     * Returns the team logo for game view.
     */
    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->type) {
                Type::CLUB => $this->club?->logo,
                Type::NATION => $this->nationalTeam?->logo,
            }
        );
    }
}