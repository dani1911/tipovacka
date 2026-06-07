<?php

namespace App\Filament\Resources\StagePredictions\Schemas;

use App\Models\Team;
use App\Models\Tournament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class StagePredictionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tournament_id')
                    ->options(Tournament::pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('team_id', null);
                    })
                    ->label(__('Tournament'))
                    ->required(),
                Select::make('stage_id')
                    ->relationship('stage', 'name')
                    ->label(__('Stage'))
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label(__('User'))
                    ->required(),
                Select::make('team_id')
                    ->options(function (Get $get) {
                        $tournament = Tournament::find($get('tournament_id'));
                        if (!$tournament) return [];

                        return Team::where('type', $tournament->type)
                            ->with(['club', 'nationalTeam.country'])
                            ->get()
                            ->pluck('name', 'id');
                    })
                    ->label(__('Team')),
                TextInput::make('points')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
