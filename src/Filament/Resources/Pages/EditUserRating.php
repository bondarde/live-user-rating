<?php

namespace BondarDe\LiveUserRating\Filament\Resources\Pages;

use BondarDe\LiveUserRating\Filament\Resources\UserRatingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserRating extends EditRecord
{
    protected static string $resource = UserRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
