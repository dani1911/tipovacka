<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\GamePredictions\GamePredictionResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GamePredictionsRelationManager extends RelationManager
{
    protected static string $relationship = 'gamePredictions';

    protected static ?string $relatedResource = GamePredictionResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ])
            ->columns([
                TextColumn::make('game.gameTeams')
                    ->label(__('Game'))
                    ->searchable(),
                TextColumn::make('colonScore')
                    ->label(__('Prediction'))
                    ->alignCenter(),
                TextColumn::make('winnerTeam.name')
                    ->searchable(),
                TextColumn::make('points')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
        ;
    }
}
