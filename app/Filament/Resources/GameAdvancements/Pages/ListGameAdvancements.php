<?php

namespace App\Filament\Resources\GameAdvancements\Pages;

use App\Filament\Resources\GameAdvancements\GameAdvancementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGameAdvancements extends ListRecords
{
    protected static string $resource = GameAdvancementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
