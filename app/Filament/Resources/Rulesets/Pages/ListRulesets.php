<?php

namespace App\Filament\Resources\Rulesets\Pages;

use App\Filament\Resources\Rulesets\RulesetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRulesets extends ListRecords
{
    protected static string $resource = RulesetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
