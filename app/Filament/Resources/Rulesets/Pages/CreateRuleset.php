<?php

namespace App\Filament\Resources\Rulesets\Pages;

use App\Filament\Resources\Rulesets\RulesetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRuleset extends CreateRecord
{
    protected static string $resource = RulesetResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
