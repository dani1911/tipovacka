<?php

namespace App\Filament\Resources\Rulesets\Schemas;

use App\Enums\Phase;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RulesetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tournament_id')
                    ->relationship('tournament', 'name')
                    ->required(),
                Select::make('phase')
                    ->options(Phase::class)
                    ->required(),
                TextInput::make('points_exact_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('points_match_winner')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('points_group_winner')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('points_tournament_winner')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('deadline')
                    ->required(),
            ]);
    }
}
