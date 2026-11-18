<?php

namespace App\Filament\Resources\SportMatches\Pages;

use App\Filament\Resources\SportMatches\SportMatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSportMatches extends ListRecords
{
    protected static string $resource = SportMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
