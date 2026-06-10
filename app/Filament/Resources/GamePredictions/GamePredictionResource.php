<?php

namespace App\Filament\Resources\GamePredictions;

use App\Filament\Resources\GamePredictions\Pages\CreateGamePrediction;
use App\Filament\Resources\GamePredictions\Pages\EditGamePrediction;
use App\Filament\Resources\GamePredictions\Pages\ListGamePredictions;
use App\Filament\Resources\GamePredictions\Schemas\GamePredictionForm;
use App\Filament\Resources\GamePredictions\Tables\GamePredictionsTable;
use App\Models\GamePrediction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class GamePredictionResource extends Resource
{
    protected static ?string $model = GamePrediction::class;

    public static function getNavigationParentItem(): string
    {
        return __('users.navigation_label');
    }

    public static function form(Schema $schema): Schema
    {
        return GamePredictionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GamePredictionsTable::configure($table);
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
            'index' => ListGamePredictions::route('/'),
            'create' => CreateGamePrediction::route('/create'),
            'edit' => EditGamePrediction::route('/{record}/edit'),
        ];
    }
}
