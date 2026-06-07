<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\Attributes\Translatable;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'abbreviation', 'flag'])]
#[WithoutTimestamps]
#[Translatable('name')]
class Country extends Model
{
    use HasFactory, HasTranslations;

    /**
     * Gets the association that the country is part of.
     */
    public function association(): BelongsTo
    {
        return $this->belongsTo(Association::class);
    }

    /**
     * Gets the clubs that are from the country.
     */
    public function clubs(): HasMany
    {
        return $this->hasMany(Club::class);
    }

    /**
     * Gets the national teams that represent the country.
     */
    public function nationalTeams(): HasMany
    {
        return $this->hasMany(NationalTeam::class);
    }
}
