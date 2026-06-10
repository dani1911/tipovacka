<?php

namespace App\Filament\Resources\Games\Schemas;

use App\Models\Stage;
use App\Models\StageTeam;
use App\Models\Tournament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class GameForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('tournament_id')
                            ->columnSpan(3)
                            ->relationship('tournament', 'name')
                            ->afterStateUpdated(function (Set $set) {
                                $set('home_team_id', null);
                                $set('away_team_id', null);
                            })
                            ->required(),
                        TextInput::make('game_number')
                            ->label(__('Game #'))
                            ->required(),
                        Select::make('stage_id')
                            ->relationship('stage', 'name')
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('home_team_id', null);
                                $set('away_team_id', null);
                            })
                            ->required(),
                        DateTimePicker::make('game_time')
                            ->required(),
                    ]),
                Section::make()
                    ->columns(['default' => 4])
                    ->schema([
                        Select::make('home_team_id')
                            ->columnSpan(
                                fn(string $operation): string|array => $operation === 'create' ? 'full' : ['default' => 3]
                            )
                            ->label(__('Home team'))
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
                                ),
                        TextInput::make('home_team_score')
                            ->columnSpan([
                                'default' => 1
                            ])
                            ->label(__('Goals'))
                            ->numeric()
                            ->hiddenOn('create'),
                        Select::make('away_team_id')
                            ->columnSpan(
                                fn(string $operation): string|array => $operation === 'create' ? 'full' : ['default' => 3]
                            )
                            ->label(__('Away team'))
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
                                ->getOptionLabelUsing(
                                    fn($value): ?string =>
                                    StageTeam::where('team_id', $value)
                                        ->with(['team.club', 'team.nationalTeam.country'])
                                        ->first()
                                        ?->team?->name
                            ),
                        TextInput::make('away_team_score')
                            ->columnSpan([
                                'default' => 1
                            ])
                            ->label(__('Goals'))
                            ->numeric()
                            ->hiddenOn('create'),
                        Select::make('winner_team_id')
                            ->columnSpan(['default' => 4])
                            ->label(__('Winning team'))
                            ->hiddenOn('create')
                            ->options(function (Get $get) {
                                $homeTeamId = $get('home_team_id');
                                $awayTeamId = $get('away_team_id');

                                if (!$homeTeamId || !$awayTeamId) return [];

                                return StageTeam::whereIn('team_id', [$homeTeamId, $awayTeamId])
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
                                ),
                    ]),
            ]);
    }
}
