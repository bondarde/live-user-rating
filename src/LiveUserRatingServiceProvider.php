<?php

namespace BondarDe\LiveUserRating;

use BondarDe\LiveUserRating\Livewire\UserRatingSurvey;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LiveUserRatingServiceProvider extends ServiceProvider
{
    //    public function register(): void
    //    {
    //        parent::register();
    // //
    // //        $this->mergeConfigFrom(
    // //            __DIR__ . '/../config/lox.php',
    // //            'lox',
    // //        );
    //    }
    //
    public function boot(): void
    {
        $this->configureViews();
        $this->configureTranslations();
        $this->configurePublishing();
        $this->configureLivewire();
    }

    private function configureViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'live-user-feedback');
        //
        //        foreach (self::$components as $alias => $component) {
        //            Blade::component(self::$namespace . '::' . $alias, $component);
        //        }
    }

    private function configureTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'live-user-feedback'); // , self::$namespace);
        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang');
    }

    private function configurePublishing(): void
    {
        //        $this->publishes([
        //            __DIR__ . '/../resources/scss/' => resource_path('scss/lox'),
        //        ], 'styles');
        //
        //        $this->publishes([
        //            __DIR__ . '/../resources/tailwind/burger-menu' => resource_path('tailwind/burger-menu'),
        //            __DIR__ . '/../resources/tailwind/tailwind.config.js' => base_path('tailwind.config.js'),
        //        ], 'tailwind');
        //
        $this->publishes([
            __DIR__ . '/../config/live-user-feedback.php' => config_path('live-user-feedback.php'),
            //            __DIR__ . '/../package.json' => base_path('package.json'),
            //            __DIR__ . '/../tailwind.config.js' => base_path('tailwind.config.js'),
            //            __DIR__ . '/../vite.config.js' => base_path('vite.config.js'),
            //            __DIR__ . '/../postcss.config.js' => base_path('postcss.config.js'),
        ], 'live-user-rating-config');
        //
        //        $this->publishes([
        //            __DIR__ . '/../resources/views' => resource_path('views/vendor/bondarde/lox'),
        //        ], 'views');
        //
        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'live-user-rating-migrations');
    }

    private function configureLivewire(): void
    {
        Livewire::component('user-rating-survey', UserRatingSurvey::class);
    }
}
