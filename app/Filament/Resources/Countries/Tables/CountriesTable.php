<?php

namespace App\Filament\Resources\Countries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CountriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('flag')
                    ->label('')
                    ->imageHeight('1.5rem')
                    ->alignCenter(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('abbreviation')
                    ->alignCenter()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('association_id')
                    ->relationship('association', 'abbreviation')
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
