<?php

namespace BondarDe\LiveUserRating\Constants;

use Filament\Support\Contracts\HasLabel;

enum UserRatingType: int implements HasLabel
{
    case YesNo = 2;
    case Stars = 5;
    case Nps = 10;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::YesNo => __('live-user-feedback::live-user-feedback.user_rating.yes_no.label'),
            self::Stars => __('live-user-feedback::live-user-feedback.user_rating.stars.label'),
            self::Nps => __('live-user-feedback::live-user-feedback.user_rating.nps.label'),
        };
    }

    public function options(): array
    {
        return match ($this) {
            self::YesNo => [
                1 => 'Yes',
                0 => 'No',
            ],
            self::Stars => [
                1 => 'Gefällt mir nicht',
                2 => 'Gefällt mir mäßig',
                3 => 'Könnte besser sein',
                4 => 'Gut',
                5 => 'Sehr gut',
            ],
            self::Nps => [
                1 => '1',
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
                6 => '6',
                7 => '7',
                8 => '8',
                9 => '9',
                10 => '10',
            ],
        };
    }

    public function renderOption(int $value): string
    {
        return match ($this) {
            self::Stars => (function () use ($value) {
                return '<div
                    class="group cursor-pointer text-2xl pr-1"
                    x-bind:class="{ \'text-yellow-400\': ' . $value . ' <= highlightedValue, \'opacity-50\': ' . $value . ' > highlightedValue && highlightedValue}"
                >★</div>';
            })(),
            default => throw new \Exception('Unsupported option'),
        };
    }
}
