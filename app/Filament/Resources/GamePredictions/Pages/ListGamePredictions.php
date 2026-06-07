<?php

namespace App\Filament\Resources\GamePredictions\Pages;

use App\Filament\Resources\GamePredictions\GamePredictionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGamePredictions extends ListRecords
{
    protected static string $resource = GamePredictionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
