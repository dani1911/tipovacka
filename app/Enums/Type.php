<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

/**
 * Enum with tournament types.
 */
enum Type: string implements HasColor
{
    case CLUB = 'club';
    case NATION = 'nation';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CLUB => 'emerald',
            self::NATION => 'amber',
        };
    }
}
