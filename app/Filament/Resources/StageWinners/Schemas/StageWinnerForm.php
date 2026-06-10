<?php

namespace App\Filament\Resources\StageWinners\Schemas;

use App\Models\Stage;
use App\Models\StageTeam;
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
                    ->afterStateUpdated(function (Set $set) {
                        $set('team_id', null);
                    })
                    ->required(),
                Select::make('stage_id')
                    ->relationship('stage', 'name')
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('team_id', null);
                    })
                    ->required(),
                Select::make('team_id')
                    ->label(__('Group winner'))
                    ->live()
                    ->options(function (Get $get) {
                        $tournament = Tournament::find($get('tournament_id'));
                        $stage = Stage::find($get('stage_id'));
                        if (!$tournament && !$stage) return [];

                        return StageTeam::where('tournament_id', $tournament->id)
                            ->where('stage_id', $stage->id)
                            ->with(['team.club', 'team.nationalTeam.country'])
                            ->get()
                            ->sortBy('team.name')
                            ->pluck('team.name', 'team_id');
                        })
                        ->getOptionLabelUsing(fn ($value): ?string =>
                            StageTeam::where('team_id', $value)
                                ->with(['team.club', 'team.nationalTeam.country'])
                                ->first()
                                ?->team?->name
                        )
                    ->required(),
            ]);
    }
}
