<?php

namespace App\Filament\Resources\Tournaments\Schemas;

use App\Enums\Type;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TournamentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('abbreviation')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('type')
                    ->options(Type::class)
                    ->required(),
                DatePicker::make('start_date')
                    ->format('Y-m-d'),
                DatePicker::make('end_date')
                    ->format('Y-m-d'),
                Toggle::make('is_active')
                    ->required(),
                FileUpload::make('logo')
                    ->image()
                    ->preserveFilenames()
                    ->directory('img/tournament')
                    ->visibility('public'),
        ]);
    }
}
