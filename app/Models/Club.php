<?php

namespace App\Models;

use App\Enums\Type;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'abbreviation', 'logo', 'country_id'])]
#[WithoutTimestamps]
class Club extends Model
{
    use HasFactory;

    /**
     * Automatically creates a new team record.
     */
    protected static function booted(): void
    {
        static::creating(function (Club $club) {
            $team = Team::create(['type' => Type::CLUB]);
            $club->team_id = $team->id;
        });
    }

    /**
     * Gets the country that the club is from.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Gets the team that represents the club in the tournament.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
