<?php

namespace BondarDe\LiveUserRating\Filament\Resources;

use BondarDe\LiveUserRating\Models\UserRating;
use Carbon\Carbon;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserRatingResource extends Resource
{
    protected static ?string $model = UserRating::class;

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedStar;

    protected static ?string $label = 'User Rating';
    protected static ?string $pluralLabel = 'User Ratings';

    public static function infolist(Schema $schema): Schema
    {
        return $schema
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

    public static function form(Schema $schema): Schema
    {
        return $schema
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
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
