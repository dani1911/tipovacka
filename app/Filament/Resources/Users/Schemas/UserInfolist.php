<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Detail'))
                    ->inlineLabel()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->label('E-mail'),
                        IconEntry::make('paid')
                            ->label(__('Paid'))
                            ->icon(fn(string $state): Heroicon => match ($state) {
                                '1' => Heroicon::CheckCircle,
                                '0' => Heroicon::XCircle,
                            })
                            ->color(fn(string $state): string => match ($state) {
                                '1' => 'success',
                                '0' => 'gray',
                            }),
                        IconEntry::make('banned')
                            ->label(__('Banned'))
                            ->icon(fn(string $state): Heroicon => match ($state) {
                                '1' => Heroicon::MinusCircle,
                                '0' => Heroicon::XCircle,
                            })
                            ->color(fn(string $state): string => match ($state) {
                                '1' => 'danger',
                                '0' => 'gray',
                            }),
                    ])
            ]);
    }
}
