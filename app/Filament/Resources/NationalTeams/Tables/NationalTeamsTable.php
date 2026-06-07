<?php

namespace App\Filament\Resources\NationalTeams\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NationalTeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('')
                    ->alignCenter(),
                TextColumn::make('country.name')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('country.flag')
                    ->label('')
                    ->imageHeight('1.5rem')
                    ->alignCenter(),
                TextColumn::make('country.association.abbreviation')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'AFC' => 'yellow',
                        'CAF' => 'grey',
                        'CONCACAF' => 'red',
                        'CONMEBOL' => 'rose',
                        'OFC' => 'green',
                        'UEFA' => 'sky',
                    })
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('country.association_id')
                    ->relationship('country.association', 'abbreviation')
                    ->label(__('Association')),
            ])
            ->defaultSort('country.name', direction: 'asc')
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
