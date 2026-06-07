<?php

namespace App\Filament\Resources\GamePredictions\Schemas;

use App\Models\Game;
use App\Models\Team;
use App\Models\Tournament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class GamePredictionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tournament_id')
                    ->options(Tournament::pluck('name', 'id'))
                    ->afterStateHydrated(
                        fn(Set $set, $record) => $set('tournament_id', $record?->game?->tournament_id)
                    )
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('game_id', null);
                    })
                    ->required(),
                Select::make('game_id')
                    ->options(function (Get $get) {
                        $tournamentId = $get('tournament_id');
                        if (!$tournamentId) return [];

                        return Game::where('tournament_id', $tournamentId)
                            ->whereNotNull('home_team_id')
                            ->whereNotNull('away_team_id')
                            ->with([
                                'homeTeam.club',
                                'homeTeam.nationalTeam.country',
                                'awayTeam.club',
                                'awayTeam.nationalTeam.country',
                            ])
                            ->get()
                            ->mapWithKeys(fn(Game $game) => [
                                $game->id => "{$game->homeTeam->name} - {$game->awayTeam->name}"
                            ]);
                    })
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('winner_team_id', null);
                    })
                    ->label(__('Game'))
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('home_team_score')
                    ->numeric(),
                TextInput::make('away_team_score')
                    ->numeric(),
                Select::make('winner_team_id')
                    ->options(function(Get $get) {
                        $game = Game::find($get('game_id'));
                        if (!$game) return [];

                        return Team::whereIn('id', [$game->home_team_id, $game->away_team_id])
                            ->with(['club', 'nationalTeam.country'])
                            ->get()
                            ->pluck('name', 'id');
                    }),
            ]);
    }
}
