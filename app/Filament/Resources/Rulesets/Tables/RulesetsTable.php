<?php

namespace App\Filament\Resources\Rulesets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RulesetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tournament.name')
                    ->searchable(),
                TextColumn::make('phase')
                    ->badge()
                    ->searchable(),
                TextColumn::make('points_exact_score')
                    ->alignCenter()
                    ->numeric(),
                TextColumn::make('points_match_winner')
                    ->alignCenter()
                    ->numeric(),
                TextColumn::make('points_group_winner')
                    ->alignCenter()
                    ->numeric(),
                TextColumn::make('points_tournament_winner')
                    ->alignCenter()
                    ->numeric(),
                TextColumn::make('deadline')
                    ->dateTime('d. m. Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
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
