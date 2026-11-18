<?php

namespace App\Filament\Resources\SportMatches;

use App\Filament\Resources\SportMatches\Pages\CreateSportMatch;
use App\Filament\Resources\SportMatches\Pages\EditSportMatch;
use App\Filament\Resources\SportMatches\Pages\ListSportMatches;
use App\Filament\Resources\SportMatches\Pages\ViewSportMatch;
use App\Filament\Resources\SportMatches\Schemas\SportMatchForm;
use App\Filament\Resources\SportMatches\Schemas\SportMatchInfolist;
use App\Filament\Resources\SportMatches\Tables\SportMatchesTable;
use App\Models\SportMatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SportMatchResource extends Resource
{
    protected static ?string $model = SportMatch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SportMatchForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SportMatchInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SportMatchesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSportMatches::route('/'),
            'create' => CreateSportMatch::route('/create'),
            'view' => ViewSportMatch::route('/{record}'),
            'edit' => EditSportMatch::route('/{record}/edit'),
        ];
    }
}
