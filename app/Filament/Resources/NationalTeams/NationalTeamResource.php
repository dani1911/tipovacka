<?php

namespace App\Filament\Resources\NationalTeams;

use App\Filament\Resources\NationalTeams\Pages\CreateNationalTeam;
use App\Filament\Resources\NationalTeams\Pages\EditNationalTeam;
use App\Filament\Resources\NationalTeams\Pages\ListNationalTeams;
use App\Filament\Resources\NationalTeams\Schemas\NationalTeamForm;
use App\Filament\Resources\NationalTeams\Tables\NationalTeamsTable;
use App\Models\NationalTeam;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class NationalTeamResource extends Resource
{
    protected static ?string $model = NationalTeam::class;

    public static function getNavigationParentItem(): string
    {
        return __('teams.navigation_label');
    }

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('national_teams.navigation_label');
    }

    public static function getRecordTitleAttribute(): string
    {
        return __('national_teams.title');
    }

    public static function form(Schema $schema): Schema
    {
        return NationalTeamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NationalTeamsTable::configure($table);
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
            'index' => ListNationalTeams::route('/'),
            'create' => CreateNationalTeam::route('/create'),
            'edit' => EditNationalTeam::route('/{record}/edit'),
        ];
    }
}
