<?php

namespace App\Filament\Resources\SportMatches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SportMatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('sport_type')
                    ->label('Sport')
                    ->badge()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'football' => 'Football',
                        'cricket' => 'Cricket',
                        'custom' => 'Custom',
                        default => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        'football' => 'success',
                        'cricket' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('competition')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('home_team')
                    ->label('Home Team')
                    ->searchable(),

                TextColumn::make('away_team')
                    ->label('Away Team')
                    ->searchable(),

                ImageColumn::make('background_image')
                    ->label('Card Background')
                    ->height(55)
                    ->width(100)
                    ->square(false),

                TextColumn::make('match_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('match_time')
                    ->label('Time'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'live' => 'danger',
                        'upcoming' => 'info',
                        'finished' => 'success',
                        'postponed' => 'warning',
                        default => 'gray',
                    }),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('match_date', 'desc')
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
