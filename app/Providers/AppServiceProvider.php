<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Socialite OAuth providers
        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('discord', \SocialiteProviders\Discord\Provider::class);
            $event->extendSocialite('spotify', \SocialiteProviders\Spotify\Provider::class);
            $event->extendSocialite('twitch', \SocialiteProviders\Twitch\Provider::class);
            $event->extendSocialite('x-twitter', \SocialiteProviders\Twitter\Provider::class);
        });
    }
}
