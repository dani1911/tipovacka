<?php

namespace App\Filament\Resources\Associations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssociationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('abbreviation')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'AFC' => 'yellow',
                        'CAF' => 'grey',
                        'CONCACAF' => 'red',
                        'CONMEBOL' => 'rose',
                        'OFC' => 'green',
                        'UEFA' => 'sky',
                    }),
                TextColumn::make('area'),
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
