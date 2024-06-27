<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
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
     * Get the advancing team of a game.
     */
    public function advancingTeam(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'advancing_team_id');
    }
}
