<?php

namespace App\Filament\Resources\NationalTeams\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class NationalTeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->image()
                    ->preserveFilenames()
                    ->directory('img/logo/nation')
                    ->visibility('public'),
                Select::make('country_id')
                    ->relationship('country', 'name')
                    ->required(),
            ]);
    }
}
