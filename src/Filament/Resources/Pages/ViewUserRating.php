<?php

namespace BondarDe\LiveUserRating\Filament\Resources\Pages;

use BondarDe\LiveUserRating\Filament\Resources\UserRatingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserRating extends ViewRecord
{
    protected static string $resource = UserRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
