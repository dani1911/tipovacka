<?php

namespace App\Models;

use App\Models\GamePrediction;
use App\Models\StagePrediction;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

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
     * Checks whether user has sufficient role to access the admin panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['admin', 'super_admin']);
    }

    /**
     * Gets the game predictions associated with the user.
     *
     * @return HasMany
     */
    public function gamePredictions(): HasMany
    {
        return $this->hasMany(GamePrediction::class);
    }

    /**
     * Gets the stage predictions associated with the user.
     * 
     * @return HasMany
     */
    public function stagePredictions(): HasMany
    {
        return $this->hasMany(StagePrediction::class);
    }

    /**
     * Calculates total points amassed from predictions by an user.
     */
    public function totalPoints(): Attribute
    {
        return Attribute::make(
            get: fn() => ((int) $this->game_predictions_sum_points ?? 0) + ((int) $this->stage_predictions_sum_points ?? 0)
        );
    }
}
