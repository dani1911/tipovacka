<?php

namespace App\Enums;

/**
 * Enum with destination game team positions.
 */
enum AdvancementResult: string
{
    case WINNER = 'winner';
    case LOSER = 'loser';
}
