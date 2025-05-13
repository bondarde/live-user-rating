<?php

namespace BondarDe\LiveUserRating\Models;

use BondarDe\LiveUserRating\Constants\UserRatingType;
use BondarDe\Lox\Constants\ModelCastTypes;
use BondarDe\Lox\Traits\GetsUuidOnCreation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserRating extends Model
{
    use GetsUuidOnCreation;

    const string FIELD_ID = 'id';
    const string FIELD_CREATED_AT = self::CREATED_AT;
    const string FIELD_UPDATED_AT = self::UPDATED_AT;

    const string FIELD_IS_PUBLIC = 'is_public';
    const string FIELD_USER_ID = 'user_id';
    const string FIELD_USER_AGENT = 'user_agent';
    const string FIELD_IPS = 'ips';
    const string FIELD_META = 'meta';

    const string FIELD_TYPE = 'type';
    const string FIELD_RATING = 'rating';
    const string FIELD_FEEDBACK = 'feedback';
    const string FIELD_INSTANT_ANSWER = 'instant_answer';
    const string FIELD_ANSWER = 'answer';

    const string FIELD_RATABLE_TYPE = 'ratable_type';
    const string FIELD_RATABLE_ID = 'ratable_id';

    const string REL_USER = 'user';

    protected $guarded = false;
    protected $casts = [
        self::FIELD_META => ModelCastTypes::ARRAY,
        self::FIELD_IS_PUBLIC => ModelCastTypes::BOOLEAN,
        self::FIELD_TYPE => UserRatingType::class,
        self::FIELD_RATING => ModelCastTypes::INTEGER,
        self::FIELD_IPS => ModelCastTypes::ARRAY,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function ratable(): MorphTo
    {
        return $this->morphTo();
    }
}
