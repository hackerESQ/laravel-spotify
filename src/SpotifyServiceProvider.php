<?php

namespace LumifyLabs\LaravelSpotify;

use Illuminate\Support\ServiceProvider;
use LumifyLabs\LaravelSpotify\Spotify;

class SpotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        
        $this->app->bind('spotify', function($app) {
            return new Spotify();
        });
    }

    public function boot()
    {
        
        $this->mergeConfigFrom(__DIR__.'/../config/spotify.php','spotify');

        $this->publishes([
            __DIR__.'/../config/spotify.php' => config_path('spotify.php'),
        ]);
    }
}
