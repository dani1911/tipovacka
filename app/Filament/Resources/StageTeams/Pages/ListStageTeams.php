<?php

namespace App\Filament\Resources\StageTeams\Pages;

use App\Filament\Resources\StageTeams\StageTeamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStageTeams extends ListRecords
{
    protected static string $resource = StageTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
