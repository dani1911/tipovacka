<?php

namespace App\Filament\Resources\StageWinners\Pages;

use App\Filament\Resources\StageWinners\StageWinnerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStageWinners extends ListRecords
{
    protected static string $resource = StageWinnerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
