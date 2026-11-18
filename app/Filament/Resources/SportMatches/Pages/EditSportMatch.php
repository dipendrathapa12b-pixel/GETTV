<?php

namespace App\Filament\Resources\SportMatches\Pages;

use App\Filament\Resources\SportMatches\SportMatchResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSportMatch extends EditRecord
{
    protected static string $resource = SportMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
