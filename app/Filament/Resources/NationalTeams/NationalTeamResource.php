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

    protected static ?string $navigationParentItem = 'Teams';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('National Teams');
    }

    public static function getRecordTitleAttribute(): string
    {
        return __('National Team');
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
