<?php

namespace App\Filament\Resources\Tournaments\RelationManagers;

use App\Filament\Resources\Rulesets\RulesetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RulesetsRelationManager extends RelationManager
{
    protected static string $relationship = 'rulesets';

    protected static ?string $relatedResource = RulesetResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
            ])
            ->columns([
                TextColumn::make('phase')
                    ->badge(),
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
                    ->dateTime('d. m. Y H:i:s'),
            ]);
    }
}
