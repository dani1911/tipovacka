<?php

namespace App\Filament\Resources\Stages\Schemas;

use App\Enums\Phase;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('abbreviation')
                    ->required(),
                Select::make('phase')
                    ->options(Phase::class)
                    ->required(),
            ]);
    }
}
