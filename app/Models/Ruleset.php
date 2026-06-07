<?php

namespace App\Models;

use App\Enums\Phase;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['tournament_id', 'phase', 'points_exact_score', 'points_match_winner', 'points_group_winner', 'points_tournament_winner', 'deadline'])]
#[WithoutTimestamps]
class Ruleset extends Model
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
            'deadline' => 'datetime',
            'phase' => Phase::class,
        ];
    }

    /**
     * Gets the tournament that the ruleset applies to.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Gets the stage of the tournament that the ruleset applies to.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    /**
     * Checks if the deadline for making predictions has passed.
     */
    public function hasDeadlinePassed(): bool
    {
        return now()->isAfter($this->deadline);
    }
}
