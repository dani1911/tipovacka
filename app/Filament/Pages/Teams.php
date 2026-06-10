<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;

class Teams extends Page
{
    protected string $view = 'filament.pages.teams';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = 'tabler-shirt';

    public static function getNavigationLabel(): string
    {
        return __('teams.navigation_label');
    }
}
