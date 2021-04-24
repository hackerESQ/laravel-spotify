<?php

namespace HackerESQ\LaravelSpotify;

use Illuminate\Support\ServiceProvider;

class SpotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('spotify', function ($app) {
            // pass relevant config to Spotify
            $config = $app->make('config')->get(['spotify']);

            return new Spotify($config);
        });
    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/spotify.php', 'spotify');

        $this->publishes([
            __DIR__ . '/../config/spotify.php' => config_path('spotify.php'),
        ]);
    }
}
