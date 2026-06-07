<?php

namespace App\Filament\Resources\Tournaments\RelationManagers;

use App\Filament\Resources\StageTeams\StageTeamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StageTeamsRelationManager extends RelationManager
{
    protected static string $relationship = 'stageTeams';

    protected static ?string $relatedResource = StageTeamResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
            ])
            ->columns([
                TextColumn::make('stage.name')
                    ->badge()
                    ->searchable(),
                ImageColumn::make('team.image')
                    ->label('')
                    ->alignCenter(),
                TextColumn::make('team.name'),
            ]);
    }
}
