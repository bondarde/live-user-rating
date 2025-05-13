<?php

use App\Models\User;
use BondarDe\LiveUserRating\Models\UserRating;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_ratings', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained();

            $table->boolean(UserRating::FIELD_IS_PUBLIC)->default(false);
            $table->text(UserRating::FIELD_USER_AGENT)->nullable();
            $table->text(UserRating::FIELD_IPS)->nullable();
            $table->text(UserRating::FIELD_META)->nullable();
            $table->unsignedInteger(UserRating::FIELD_TYPE);
            $table->unsignedInteger(UserRating::FIELD_RATING);
            $table->text(UserRating::FIELD_FEEDBACK)->nullable();
            $table->text(UserRating::FIELD_INSTANT_ANSWER)->nullable();
            $table->text(UserRating::FIELD_ANSWER)->nullable();

            $table->string(UserRating::FIELD_RATABLE_TYPE)->nullable()->index();
            $table->string(UserRating::FIELD_RATABLE_ID)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_ratings');
    }
};
