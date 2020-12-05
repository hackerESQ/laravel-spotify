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

    // search

    public function search($q,$type,$options=[]) {

        $accessToken = $this->generateAccessToken();

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $api->search($q,$type,$options);

    }

    // load playlist 

    public function playlist($id,$options=[]) {

        $accessToken = $this->generateAccessToken();

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $playlist = $api->getPlaylist($id,$options);
        
        return $playlist;

    }
}