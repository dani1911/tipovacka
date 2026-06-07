<?php

namespace App\Filament\Resources\GamePredictions\Pages;

use App\Filament\Resources\GamePredictions\GamePredictionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGamePrediction extends EditRecord
{
    protected static string $resource = GamePredictionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
