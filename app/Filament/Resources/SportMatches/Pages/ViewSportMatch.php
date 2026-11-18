<?php

namespace App\Filament\Resources\SportMatches\Pages;

use App\Filament\Resources\SportMatches\SportMatchResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSportMatch extends ViewRecord
{
    protected static string $resource = SportMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
