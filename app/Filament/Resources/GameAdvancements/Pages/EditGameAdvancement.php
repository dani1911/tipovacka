<?php

namespace App\Filament\Resources\GameAdvancements\Pages;

use App\Filament\Resources\GameAdvancements\GameAdvancementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGameAdvancement extends EditRecord
{
    protected static string $resource = GameAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
