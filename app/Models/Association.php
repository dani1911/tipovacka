<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\Attributes\Translatable;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'abbreviation', 'area'])]
#[WithoutTimestamps]
#[Translatable('area')]
class Association extends Model
{
    use HasTranslations;

    /**
     * Gets the countries that are from the association.
     */
    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }
}
