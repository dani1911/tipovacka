<?php

namespace App\Filament\Resources\StageTeams\Pages;

use App\Filament\Resources\StageTeams\StageTeamResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStageTeam extends EditRecord
{
    protected static string $resource = StageTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
