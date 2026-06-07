<?php

namespace App\Enums;

/**
 * Enum with destination game team positions.
 */
enum DestinationPosition: string
{
    case HOME = 'home_team_id';
    case AWAY = 'away_team_id';
}
