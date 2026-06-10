<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

/**
 * Enum with possible tournament phases.
 */
enum Phase: string implements HasLabel, HasColor
{
    case PLAYIN = 'playin';
    case PLAYOUT = 'playout';
    case GROUP = 'group';
    case KNOCKOUT = 'knockout';
    case THIRDPLACE = 'third_place';
    case FINAL = 'final';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PLAYIN => 'PlayIn',
            self::PLAYOUT => 'PlayOut',
            self::GROUP => 'Group',
            self::KNOCKOUT => 'Knockout',
            self::THIRDPLACE => 'Third Place',
            self::FINAL => 'Final',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PLAYIN => 'grey',
            self::PLAYOUT => 'zinc',
            self::GROUP => 'emerald',
            self::KNOCKOUT => 'fuchsia',
            self::THIRDPLACE => 'amber',
            self::FINAL => 'yellow',
        };
    }

    public static function knockoutPhases(): array
    {
        return [
            self::KNOCKOUT,
            self::THIRDPLACE,
            self::FINAL,
        ];
    }

    public function isKnockout(): bool
    {
        return match ($this) {
            self::KNOCKOUT, self::THIRDPLACE, self::FINAL => true,
            default => false,
        };
    }

    public function rulesetPhase(): Phase
    {
        return $this->isKnockout() ? Phase::KNOCKOUT : $this;
    }
}
