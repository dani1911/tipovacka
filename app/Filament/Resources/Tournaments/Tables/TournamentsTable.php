<?php

namespace App\Filament\Resources\Tournaments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TournamentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('abbreviation'),
                ImageColumn::make('logo')
                    ->alignCenter(),
                IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->alignCenter()
                    ->boolean(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('slug'),
                TextColumn::make('start_date')
                    ->date('d. m. Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date('d. m. Y')
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
