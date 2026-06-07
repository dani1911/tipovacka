<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('abbreviation')
                    ->required(),
                FileUpload::make('flag')
                    ->image()
                    ->preserveFilenames()
                    ->directory('img/flag')
                    ->visibility('public'),
                Select::make('association_id')
                    ->relationship('association', 'abbreviation')
                    ->required(),
            ]);
    }
}
