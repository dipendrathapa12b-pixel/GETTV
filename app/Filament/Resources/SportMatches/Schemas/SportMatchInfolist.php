<?php

namespace App\Filament\Resources\SportMatches\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SportMatchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('sport_type'),
                TextEntry::make('custom_sport_name')
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('competition')
                    ->placeholder('-'),
                TextEntry::make('home_team'),
                TextEntry::make('home_team_logo')
                    ->placeholder('-'),
                TextEntry::make('away_team'),
                TextEntry::make('away_team_logo')
                    ->placeholder('-'),
                TextEntry::make('match_date')
                    ->date(),
                TextEntry::make('match_time')
                    ->time(),
                TextEntry::make('status'),
                IconEntry::make('is_featured')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
