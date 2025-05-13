<?php

namespace BondarDe\LiveUserRating\Filament\Resources;

use BondarDe\LiveUserRating\Models\UserRating;
use Carbon\Carbon;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserRatingResource extends Resource
{
    protected static ?string $model = UserRating::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $label = 'User Rating';
    protected static ?string $pluralLabel = 'User Ratings';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make(UserRating::FIELD_RATING)
                    ->helperText(
                        fn (UserRating $record) => $record->{UserRating::FIELD_TYPE}->getLabel(),
                    ),
                TextEntry::make(UserRating::FIELD_CREATED_AT)
                    ->dateTime()
                    ->helperText(
                        fn (Carbon $state) => $state->diffForHumans(),
                    ),

                TextEntry::make(UserRating::FIELD_FEEDBACK)
                    ->placeholder('n/a')
                    ->columnSpanFull(),
                TextEntry::make(UserRating::FIELD_INSTANT_ANSWER)
                    ->placeholder('n/a'),
                TextEntry::make(UserRating::FIELD_ANSWER)
                    ->html()
                    ->placeholder('n/a')
                    ->columnSpanFull(),

                Section::make('Meta')
                    ->schema([
                        TextEntry::make(UserRating::REL_USER . '.id')
                            ->badge()
                            ->url(
                                fn (UserRating $record): ?string => $record->{UserRating::REL_USER}
                                    ? route('filament.admin.resources.users.view', $record->{UserRating::REL_USER}->id)
                                    : null,
                            )
                            ->placeholder('n/a'),
                        TextEntry::make(UserRating::FIELD_META),
                        TextEntry::make(UserRating::FIELD_IPS),
                        TextEntry::make(UserRating::FIELD_USER_AGENT)
                            ->copyable(),
                        TextEntry::make(UserRating::FIELD_RATABLE_TYPE)
                            ->placeholder('n/a'),
                        TextEntry::make(UserRating::FIELD_RATABLE_ID)
                            ->placeholder('n/a'),
                    ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make(UserRating::FIELD_RATING)
                    ->content(
                        fn (UserRating $record) => $record->{UserRating::FIELD_RATING},
                    )
                    ->helperText(
                        fn (UserRating $record) => $record->{UserRating::FIELD_TYPE}->getLabel(),
                    ),

                Textarea::make(UserRating::FIELD_FEEDBACK)
                    ->columnSpanFull(),

                RichEditor::make(UserRating::FIELD_ANSWER)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(UserRating::FIELD_CREATED_AT)
                    ->description(
                        fn (Carbon $state) => $state->diffForHumans(),
                    )
                    ->dateTime(),

                TextColumn::make(UserRating::FIELD_RATING)
                    ->description(
                        fn (UserRating $record) => $record->{UserRating::FIELD_TYPE}->getLabel(),
                    ),

                TextColumn::make(UserRating::FIELD_FEEDBACK)
                    ->placeholder('n/a')
                    ->wrap()
                    ->lineClamp(2)
                    ->description(
                        fn (UserRating $record) => $record->{UserRating::FIELD_INSTANT_ANSWER} ?? 'n/a',
                    ),
                TextColumn::make(UserRating::FIELD_ANSWER)
                    ->placeholder('n/a')
                    ->html()
                    ->wrap()
                    ->lineClamp(2),

            ])
            ->defaultSort(UserRating::FIELD_CREATED_AT, 'desc')
            ->filters([
            ])
            ->actions([
                Actions\ActionGroup::make([
                    Actions\ViewAction::make(),
                    Actions\EditAction::make(),
                    Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserRatings::route('/'),
            'view' => Pages\ViewUserRating::route('/{record}'),
            'edit' => Pages\EditUserRating::route('/{record}/edit'),
        ];
    }
}
