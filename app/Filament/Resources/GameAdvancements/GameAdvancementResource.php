<?php

namespace App\Filament\Resources\GameAdvancements;

use App\Filament\Resources\GameAdvancements\Pages\CreateGameAdvancement;
use App\Filament\Resources\GameAdvancements\Pages\EditGameAdvancement;
use App\Filament\Resources\GameAdvancements\Pages\ListGameAdvancements;
use App\Filament\Resources\GameAdvancements\Schemas\GameAdvancementForm;
use App\Filament\Resources\GameAdvancements\Tables\GameAdvancementsTable;
use App\Models\GameAdvancement;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class GameAdvancementResource extends Resource
{
    protected static ?string $model = GameAdvancement::class;

    protected static ?string $navigationParentItem = 'Games';

    public static function form(Schema $schema): Schema
    {
        return GameAdvancementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GameAdvancementsTable::configure($table);
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
            'index' => ListGameAdvancements::route('/'),
            'create' => CreateGameAdvancement::route('/create'),
            'edit' => EditGameAdvancement::route('/{record}/edit'),
        ];
    }
}
