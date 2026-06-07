<?php

namespace App\Filament\Resources\StageWinners\Pages;

use App\Filament\Resources\StageWinners\StageWinnerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStageWinner extends EditRecord
{
    protected static string $resource = StageWinnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
