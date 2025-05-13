<?php

namespace BondarDe\LiveUserRating\Filament\Resources\Pages;

use BondarDe\LiveUserRating\Filament\Resources\UserRatingResource;
use Filament\Resources\Pages\ListRecords;

class ListUserRatings extends ListRecords
{
    protected static string $resource = UserRatingResource::class;
}
