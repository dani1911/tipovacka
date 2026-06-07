<?php

namespace App\Filament\Resources\GameAdvancements\Schemas;

use App\Models\Game;
use App\Models\Tournament;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class GameAdvancementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tournament_id')
                    ->columnSpan(2)
                    ->dehydrated(false)
                    ->options(Tournament::pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('source_game_id', null);
                        $set('destination_game_id', null);
                    })
                    ->label('Tournament'),
                Select::make('source_game_id')
                    ->options(function (Get $get) {
                        $tournamentId = $get('tournament_id');
                        if (!$tournamentId) return [];

                        return Game::where('tournament_id', $tournamentId)
                            ->get()
                            ->pluck('game_number');
                    })
                    ->label(__('Source game'))
                    ->required(),
                Select::make('destination_game_id')
                    ->options(function (Get $get) {
                        $tournamentId = $get('tournament_id');
                        if (!$tournamentId) return [];

                        return Game::where('tournament_id', $tournamentId)
                            ->get()
                            ->pluck('game_number');
                    })
                    ->label(__('Destination game'))
                    ->required(),
                Select::make('result')
                    ->options(['winner' => 'Winner', 'loser' => 'Loser'])
                    ->required(),
                Select::make('destination_position')
                    ->options(['home_team_id' => 'Home team', 'away_team_id' => 'Away team'])
                    ->required(),
            ]);
    }
}
