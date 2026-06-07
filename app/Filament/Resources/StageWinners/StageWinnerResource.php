<?php

namespace App\Filament\Resources\StageWinners;

use App\Filament\Resources\StageWinners\Pages\CreateStageWinner;
use App\Filament\Resources\StageWinners\Pages\EditStageWinner;
use App\Filament\Resources\StageWinners\Pages\ListStageWinners;
use App\Filament\Resources\StageWinners\Schemas\StageWinnerForm;
use App\Filament\Resources\StageWinners\Tables\StageWinnersTable;
use App\Models\StageWinner;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StageWinnerResource extends Resource
{
    protected static ?string $model = StageWinner::class;

    protected static ?string $navigationParentItem = 'Games';

    public static function form(Schema $schema): Schema
    {
        return StageWinnerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StageWinnersTable::configure($table);
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
            'index' => ListStageWinners::route('/'),
            'create' => CreateStageWinner::route('/create'),
            'edit' => EditStageWinner::route('/{record}/edit'),
        ];
    }
}
