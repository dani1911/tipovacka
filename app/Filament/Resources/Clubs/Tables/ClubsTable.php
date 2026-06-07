<?php

namespace App\Filament\Resources\Clubs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClubsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('')
                    ->alignCenter(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('abbreviation')
                    ->searchable(),
                ImageColumn::make('country.flag')
                    ->label('')
                    ->alignCenter()
                    ->imageHeight('1.5rem')
                    ->searchable(),
                TextColumn::make('country.association.abbreviation')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('country.flag')
                    ->relationship('country', 'name')
                    ->label(__('Country')),
                SelectFilter::make('country.association_id')
                    ->relationship('country.association', 'abbreviation')
                    ->label(__('Association')),
            ])
            ->defaultSort('name', direction: 'asc')
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
