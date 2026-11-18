<?php

namespace App\Filament\Resources\SportMatches\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;


class SportMatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('sport_type')
                    ->label('Sport')
                    ->options([
                        'football' => 'Football',
                        'cricket' => 'Cricket',
                        'custom' => 'Custom Sport',
                    ])
                    ->default('football')
                    ->required()
                    ->live(),

                TextInput::make('custom_sport_name')
                    ->label('Custom Sport Name')
                    ->visible(fn(Get $get): bool => $get('sport_type') === 'custom')
                    ->required(fn(Get $get): bool => $get('sport_type') === 'custom')
                    ->maxLength(255),

                TextInput::make('title')
                    ->label('Match Title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('competition')
                    ->label('Competition / League')
                    ->maxLength(255),

                TextInput::make('home_team')
                    ->label('Home Team')
                    ->required()
                    ->maxLength(255),

                TextInput::make('home_team_logo')
                    ->label('Home Team Logo URL')
                    ->url()
                    ->nullable(),

                TextInput::make('away_team')
                    ->label('Away Team')
                    ->required()
                    ->maxLength(255),

                TextInput::make('away_team_logo')
                    ->label('Away Team Logo URL')
                    ->url()
                    ->nullable(),


                TextInput::make('background_image')
                    ->label('Card Background Image URL')
                    ->url()
                    ->placeholder('https://example.com/stadium.jpg')
                    ->helperText('Enter a direct URL to the match card background image.')
                    ->nullable(),

                DatePicker::make('match_date')
                    ->label('Match Date')
                    ->required(),

                TimePicker::make('match_time')
                    ->label('Match Time')
                    ->required(),

                Select::make('status')
                    ->options([
                        'upcoming' => 'Upcoming',
                        'live' => 'Live',
                        'finished' => 'Finished',
                        'postponed' => 'Postponed',
                    ])
                    ->default('upcoming')
                    ->required(),

                Toggle::make('is_featured')
                    ->label('Featured Match')
                    ->default(false),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
