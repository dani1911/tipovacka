<?php

namespace App\Filament\Resources\StagePredictions\Pages;

use App\Filament\Resources\StagePredictions\StagePredictionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStagePredictions extends ListRecords
{
    protected static string $resource = StagePredictionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
