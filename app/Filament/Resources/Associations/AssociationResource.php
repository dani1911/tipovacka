<?php

namespace App\Filament\Resources\Associations;

use App\Filament\Resources\Associations\Pages\CreateAssociation;
use App\Filament\Resources\Associations\Pages\EditAssociation;
use App\Filament\Resources\Associations\Pages\ListAssociations;
use App\Filament\Resources\Associations\Schemas\AssociationForm;
use App\Filament\Resources\Associations\Tables\AssociationsTable;
use App\Models\Association;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AssociationResource extends Resource
{
    protected static ?string $model = Association::class;

    public static function getNavigationParentItem(): string
    {
        return __('teams.navigation_label');
    }

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('association.navigation_label');
    }

    public static function getRecordTitleAttribute(): string
    {
        return __('association.title');
    }

    public static function form(Schema $schema): Schema
    {
        return AssociationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssociationsTable::configure($table);
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
            'index' => ListAssociations::route('/'),
            'create' => CreateAssociation::route('/create'),
            'edit' => EditAssociation::route('/{record}/edit'),
        ];
    }
}
