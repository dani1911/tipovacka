<?php

namespace App\Filament\Resources\Clubs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClubForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('abbreviation')
                    ->required(),
                FileUpload::make('logo')
                    ->image()
                    ->preserveFilenames()
                    ->directory('img/logo/club')
                    ->visibility('public'),
                Select::make('country_id')
                    ->relationship('country', 'name')
                    ->required(),
            ]);
    }
}
