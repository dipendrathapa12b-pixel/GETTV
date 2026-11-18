<?php

namespace App\Filament\Resources\HomepageSections\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HomepageSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->label('Section Title')
                    ->placeholder('Example: Live Matches')
                    ->required()
                    ->maxLength(255),

                Select::make('section_type')
                    ->label('Section Type')
                    ->options([
                        'live' => 'Live Matches',
                        'upcoming' => 'Upcoming Matches',
                        'sport' => 'Sport Category',
                        'custom' => 'Custom Section',
                    ])
                    ->required()
                    ->live(),

                Select::make('sport_type')
                    ->label('Sport Filter')
                    ->options([
                        'football' => 'Football',
                        'cricket' => 'Cricket',
                        'custom' => 'Custom Sport',
                    ])
                    ->visible(fn ($get) => $get('section_type') === 'sport'),

                TextInput::make('sort_order')
                    ->label('Display Order')
                    ->numeric()
                    ->default(0)
                    ->required(),

                TextInput::make('matches_limit')
                    ->label('Number of Matches')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(50)
                    ->default(10)
                    ->required(),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
