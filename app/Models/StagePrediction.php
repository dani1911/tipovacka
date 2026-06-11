<?php

namespace App\Models;

use App\Enums\Phase;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['tournament_id', 'stage_id', 'user_id', 'team_id', 'points'])]
class StagePrediction extends Model
{
    use HasFactory;

    /**
     * Gets the tournament that the prediction was made for.
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Gets the stage that the prediction was made for.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    /**
     * Gets the user who made the prediction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Gets the team that the prediction was made for.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Gets the stage winner for given prediction.
     */
    public function stageWinner(): HasOne
    {
        return $this->hasOne(StageWinner::class, 'stage_id', 'stage_id')
            ->where('tournament_id', $this->tournament_id);
    }

    /**
     * Gets the points amassed by the user for the prediction.
     */
    public function scopeEarned($query)
    {
        return $query->whereNotNull('points')->where('points', '>', 0);
    }

    /**
     * Determines if the prediction is correct.
     */
    protected function isCorrect(): Attribute
    {
        return Attribute::make(
            get: fn() => StageWinner::where('tournament_id', $this->tournament_id)
                ->where('stage_id', $this->stage_id)
                ->where('team_id', $this->team_id)
                ->first()
        );
    }

    public function predictionStatus(): string
    {
        if (!$this->stageWinner) {
            return 'pending';
        }

        return $this->stageWinner->team_id === $this->team_id ? 'correct' : 'incorrect';
    }
}
