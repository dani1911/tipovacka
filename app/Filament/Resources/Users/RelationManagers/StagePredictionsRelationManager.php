<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\StagePredictions\StagePredictionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StagePredictionsRelationManager extends RelationManager
{
    protected static string $relationship = 'stagePredictions';

    protected static ?string $relatedResource = StagePredictionResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ])
            ->columns([
                TextColumn::make('tournament.name')
                    ->searchable(),
                TextColumn::make('stage.name')
                    ->badge()
                    ->searchable(),
                TextColumn::make('team.name')
                    ->label(__('Team'))
                    ->searchable(),
                TextColumn::make('points')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
        ;
    }
}
