<?php

namespace App\Filament\Resources\Streams\Schemas;

use App\Models\SportMatch;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StreamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('sport_match_id')
                    ->label('Select Match')
                    ->options(
                        SportMatch::query()
                            ->orderByDesc('match_date')
                            ->pluck('title', 'id')
                    )
                    ->searchable()
                    ->required(),

                TextInput::make('name')
                    ->label('Stream Name')
                    ->placeholder('Example: Primary Player')
                    ->required()
                    ->maxLength(255),

                Select::make('player_type')
                    ->label('Player Type')
                    ->options([
                        'videojs' => 'Video.js (MP4 / HLS)',
                        'iframe' => 'Iframe Embed',
                    ])
                    ->default('iframe')
                    ->required(),

                TextInput::make('stream_url')
                    ->label('Stream URL')
                    ->placeholder('https://example.com/stream.m3u8')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_primary')
                    ->label('Primary Stream')
                    ->default(false),

                TextInput::make('sort_order')
                    ->label('Display Order')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
