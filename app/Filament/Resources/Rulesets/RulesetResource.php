<?php

namespace App\Filament\Resources\Rulesets;

use App\Filament\Resources\Rulesets\Pages\CreateRuleset;
use App\Filament\Resources\Rulesets\Pages\EditRuleset;
use App\Filament\Resources\Rulesets\Pages\ListRulesets;
use App\Filament\Resources\Rulesets\Schemas\RulesetForm;
use App\Filament\Resources\Rulesets\Tables\RulesetsTable;
use App\Models\Ruleset;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class RulesetResource extends Resource
{
    protected static ?string $model = Ruleset::class;

    protected static ?string $navigationParentItem = 'Tournaments';

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('Rulesets');
    }

    public static function getRecordTitleAttribute(): string
    {
        return __('Ruleset');
    }

    public static function form(Schema $schema): Schema
    {
        return RulesetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RulesetsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRulesets::route('/'),
            'create' => CreateRuleset::route('/create'),
            'edit' => EditRuleset::route('/{record}/edit'),
        ];
    }
}
