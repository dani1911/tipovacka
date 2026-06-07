<?php

namespace App\Filament\Resources\Games\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class GamesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tournament.name')
                    ->badge()
                    // ->color(fn(string $state): string => match ($state) {
                    //     'UEFA Euro 2024' => 'blue',
                    //     'FIFA World Cup 2026' => 'black',
                    // })
                    ->searchable(),
                TextColumn::make('stage.name')
                    ->badge()
                    ->searchable(),
                TextColumn::make('homeTeam.name')
                    ->searchable(),
                TextColumn::make('awayTeam.name')
                    ->searchable(),
                TextColumn::make('colonScore')
                    ->label(__('Score'))
                    ->alignCenter(),
                TextColumn::make('winnerTeam.name'),
                TextColumn::make('game_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('game_number')
                    ->label(__('Game #'))
                    ->alignCenter(),
            ])
            ->defaultPaginationPageOption(50)
            ->defaultSort('game_time', direction: 'asc')
            ->filters([
                // TODO make filter with today's games
                Filter::make('active_tournament')
                    ->schema([
                        Checkbox::make('active_tournament'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['active_tournament']) {
                            $query->whereHas('tournament', fn(Builder $query) => $query->where('is_active', true));
                        }
                    })
                    ->label(__('Active tournament')),
                SelectFilter::make('tournament.name')
                    ->relationship('tournament', 'name')
                    ->label(__('Tournament')),
                // TODO stage filter based on Tournament filter - disabled until tournament is selected
                // SelectFilter::make('tournament.name')
                //     ->relationship('tournament', 'name')
                //     ->label(__('Tournament')),
            ])->persistFiltersInSession()
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
