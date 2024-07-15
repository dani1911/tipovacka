<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class GamePrediction extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user that the prediction belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game that the prediction belongs to.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Get the advancing team of a game.
     */
    public function advancingTeam(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'advancing_team_id');
    }

    public function getScoreAttribute()
    {
        (isset($this->home_team_goals) && isset($this->away_team_goals)) ? $score = $this->home_team_goals . ':' . $this->away_team_goals :  $score = '';

        return $score;
    }
}
