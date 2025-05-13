<?php

namespace BondarDe\LiveUserRating\Livewire;

use BondarDe\LiveUserRating\Constants\UserRatingType;
use BondarDe\LiveUserRating\Models\UserRating;
use Illuminate\View\View;
use Livewire\Component;

class UserRatingSurvey extends Component
{
    public ?int $type = null;

    public ?string $heading = null;
    public ?string $description = null;
    public ?string $textareaPlaceholder = null;

    public ?int $storedRating = null;
    public ?string $instantAnswer = null;

    public array $meta = [];

    public ?string $ratingUuid = null;

    public string $feedbackText = '';

    public function storeRating(
        int $rating,
    ): void {
        if ($this->storedRating !== null) {
            return;
        }

        $this->storedRating = $rating;

        $request = request();

        $userRating = UserRating::query()->create([
            UserRating::FIELD_TYPE => UserRatingType::from($this->type),
            UserRating::FIELD_RATING => $rating,
            UserRating::FIELD_USER_AGENT => $request->userAgent(),
            UserRating::FIELD_IPS => $request->ips(),
            UserRating::FIELD_META => $this->meta,
            UserRating::FIELD_USER_ID => $request->user()?->id,
        ]);
        $this->ratingUuid = $userRating->uuid;

        $ratableResolver = config('live-user-feedback.ratable_resolver');
        if ($ratableResolver) {
            $resolver = new $ratableResolver();
            $ratable = $resolver($this->meta);

            if ($ratable) {
                $userRating->ratable()
                    ->associate($ratable)
                    ->save();
            }
        }
    }

    public function storeFeedback(): void
    {
        $userRating = UserRating::query()
            ->where('uuid', $this->ratingUuid)
            ->whereNull(UserRating::FIELD_FEEDBACK)
            ->sole();

        $this->instantAnswer = 'Vielen Dank für Ihr Feedback!';

        $userRating->update([
            UserRating::FIELD_FEEDBACK => $this->feedbackText,
            UserRating::FIELD_INSTANT_ANSWER => $this->instantAnswer,
        ]);
    }

    public function render(): View
    {
        $userRatingType = UserRatingType::from($this->type);

        return view('live-user-feedback::livewire.user-rating-survey', compact(
            'userRatingType',
        ));
    }
}
