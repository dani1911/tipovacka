<?php

namespace App\Filament\Resources\Associations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssociationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('abbreviation')
                    ->required(),
                TextInput::make('area')
                    ->required(),
            ]);
    }
}
