<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $dates = ['game_date'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the home team of a game.
     */
    public function homeTeam(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'home_team_id');
    }

    /**
     * Get the away team of a game.
     */
    public function awayTeam(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'away_team_id');
    }

    /**
     * Get the game predictions of a user.
     */
    public function gamePredictions(): HasMany
    {
        return $this->hasMany(GamePrediction::class);
    }

    /**
     * Get the stage winner predictions of a user.
     */
    public function stagePredictions(): HasMany
    {
        return $this->hasMany(StagePrediction::class);
    }

    /**
     * Returns full game result.
     *
     * @return string difference in days between dates
     */
    public function getFinalResultAttribute()
    {
        return (isset($this->home_team_goals) && isset($this->away_team_goals)) ? $this->home_team_goals . ':' . $this->away_team_goals : '';
    }

    /**
     * Get the stage that the game belongs to.
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }
}
