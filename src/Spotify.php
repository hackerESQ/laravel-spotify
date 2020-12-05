<?php

namespace LumifyLabs\LaravelSpotify;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

class Spotify {

    public function generateAccessToken() {
        return cache()->remember('spotify_access_token', 3600, function () {
            $session = new Session(
                config('spotify.client_id'),
                config('spotify.client_secret')
            );

            $session->requestCredentialsToken();
            
            return $session->getAccessToken();
        });
    }

    public function getSong() {

        $accessToken = $this->generateAccessToken();

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        // It's now possible to request data from the Spotify catalog

        return json_encode($api->getTrack('7EjyzZcbLxW7PaaLua9Ksb'));

    }
}