<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['tournament_id', 'stage_id', 'team_id'])]
#[WithoutTimestamps]
class StageWinner extends Model
{
    use HasFactory;

    /**
     * Gets the tournament that the stage winner is part of.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Gets the stage that the winner is for.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    /**
     * Gets the team that won the stage.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Checks if the stage winner is set.
     */
    public function isSet(): bool
    {
        return false; // TODO if stage winner is set
    }
}
