<?php

namespace App\Filament\Resources\GameAdvancements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GameAdvancementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sourceGame.game_number')
                    ->searchable(),
                TextColumn::make('destinationGame.game_number')
                    ->searchable(),
                TextColumn::make('result')
                    ->badge(),
                TextColumn::make('destination_position')
                    ->badge(),
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
