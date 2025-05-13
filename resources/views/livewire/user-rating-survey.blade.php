<x-filament::section :$heading :$description>
    @if($instantAnswer)
        {{ $instantAnswer }}
    @else
        <div
            x-data="{ description: '', selectedValue: null, highlightedValue: null }"
        >
            <div
                class="text-sm opacity-65"
                x-bind:class="{'hidden': selectedValue !== null}"
            >
                {{ __('live-user-feedback::live-user-feedback.rating_caption') }}:
            </div>
            <div
                class="flex items-center mb-3"
            >
                @foreach ($userRatingType->options() as $value => $label)
                    <div
                        wire:key="{{ $value }}"
                        @click="
                            if(selectedValue === null) {
                                selectedValue = {{ $value }};
                                $wire.storeRating({{ $value }});
                            }"
                        @mouseover="description = '{{ $label }}'; highlightedValue = selectedValue ?? {{ $value }}"
                        @mouseout="description = ''; highlightedValue = selectedValue ?? null"
                    >
                        {!! $userRatingType->renderOption($value) !!}
                    </div>
                @endforeach
                <div
                    class="text-sm opacity-65 pl-3"
                    x-text="description"
                ></div>
            </div>

            <p
                class="text-sm mb-3 hidden"
                x-bind:class="{'hidden': selectedValue === null}"
            >
                {{ __('live-user-feedback::live-user-feedback.rating_instant_answer_1') }}
                <br>
                {{ __('live-user-feedback::live-user-feedback.rating_instant_answer_2') }}
            </p>

            <div
                class="text-sm opacity-65"
            >
                {{ __('live-user-feedback::live-user-feedback.feedback_caption') }}:
            </div>
            <x-lox::form.textarea
                wire:model="feedbackText"
                name="feedbackText"
                rows="6"
                :placeholder="$textareaPlaceholder"
            />

            <x-lox::button
                class="mt-4"
                x-bind:disabled="selectedValue === null"
                wire:click="storeFeedback"
            >
                {{ __('live-user-feedback::live-user-feedback.form_cta') }}
            </x-lox::button>
        </div>
    @endif

</x-filament::section>
