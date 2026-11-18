<?php

namespace App\Filament\Resources\HomepageSections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomepageSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Section Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('section_type')
                    ->label('Section Type')
                    ->badge(),

                TextColumn::make('sport_type')
                    ->label('Sport Filter')
                    ->badge()
                    ->placeholder('All sports'),

                TextColumn::make('sort_order')
                    ->label('Display Order')
                    ->sortable(),

                TextColumn::make('matches_limit')
                    ->label('Matches Limit'),

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
