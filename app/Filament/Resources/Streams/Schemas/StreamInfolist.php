<?php

namespace App\Filament\Resources\Streams\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StreamInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('sportMatch.title')
                    ->label('Sport match'),
                TextEntry::make('name'),
                TextEntry::make('player_type'),
                TextEntry::make('stream_url')
                    ->columnSpanFull(),
                IconEntry::make('is_primary')
                    ->boolean(),
                TextEntry::make('sort_order')
                    ->numeric(),
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
