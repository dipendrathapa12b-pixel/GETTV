<?php

namespace App\Filament\Resources\Streams\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StreamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('sportMatch.title')
                    ->label('Match')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Stream Name')
                    ->searchable(),

                TextColumn::make('player_type')
                    ->label('Player')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'videojs' => 'Video.js',
                        'iframe' => 'Iframe',
                        default => $state,
                    }),

                TextColumn::make('stream_url')
                    ->label('Stream URL')
                    ->limit(35)
                    ->toggleable(),

                IconColumn::make('is_primary')
                    ->label('Primary')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
