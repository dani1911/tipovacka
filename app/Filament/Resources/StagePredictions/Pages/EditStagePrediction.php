<?php

namespace App\Filament\Resources\StagePredictions\Pages;

use App\Filament\Resources\StagePredictions\StagePredictionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStagePrediction extends EditRecord
{
    protected static string $resource = StagePredictionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
