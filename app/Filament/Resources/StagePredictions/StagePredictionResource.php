<?php

namespace App\Filament\Resources\StagePredictions;

use App\Filament\Resources\StagePredictions\Pages\CreateStagePrediction;
use App\Filament\Resources\StagePredictions\Pages\EditStagePrediction;
use App\Filament\Resources\StagePredictions\Pages\ListStagePredictions;
use App\Filament\Resources\StagePredictions\Schemas\StagePredictionForm;
use App\Filament\Resources\StagePredictions\Tables\StagePredictionsTable;
use App\Models\StagePrediction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StagePredictionResource extends Resource
{
    protected static ?string $model = StagePrediction::class;

    protected static ?string $navigationParentItem = 'Users';

    public static function form(Schema $schema): Schema
    {
        return StagePredictionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StagePredictionsTable::configure($table);
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
            'index' => ListStagePredictions::route('/'),
            'create' => CreateStagePrediction::route('/create'),
            'edit' => EditStagePrediction::route('/{record}/edit'),
        ];
    }
}
