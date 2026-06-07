<?php

namespace App\Filament\Resources\StageWinners\Schemas;

use App\Models\Team;
use App\Models\Tournament;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class StageWinnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tournament_id')
                    ->relationship('tournament', 'name')
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('team_id', null);
                    })
                    ->required(),
                Select::make('stage_id')
                    ->relationship('stage', 'name')
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
                    ->label(__('Team'))
                    ->required(),
            ]);
    }
}
