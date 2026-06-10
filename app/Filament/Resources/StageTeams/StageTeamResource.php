<?php

namespace App\Filament\Resources\StageTeams;

use App\Filament\Resources\StageTeams\Pages\CreateStageTeam;
use App\Filament\Resources\StageTeams\Pages\EditStageTeam;
use App\Filament\Resources\StageTeams\Pages\ListStageTeams;
use App\Filament\Resources\StageTeams\Schemas\StageTeamForm;
use App\Filament\Resources\StageTeams\Tables\StageTeamsTable;
use App\Models\StageTeam;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StageTeamResource extends Resource
{
    protected static ?string $model = StageTeam::class;

    public static function getNavigationParentItem(): string
    {
        return __('tournaments.navigation_label');
    }

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return StageTeamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StageTeamsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStageTeams::route('/'),
            'create' => CreateStageTeam::route('/create'),
            'edit' => EditStageTeam::route('/{record}/edit'),
        ];
    }
}
