<?php

namespace HackerESQ\LaravelSpotify;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

class Spotify {

    protected string $client_id = '';
    protected string $client_secret = '';

    public function __construct() {
        $this->client_id = config('spotify.client_id') ?? '';
        $this->client_secret = config('spotify.client_secret') ?? '';
    }

    public function setCredentials($credentials) {
        $this->client_id = $credentials['client_id'];
        $this->client_secret = $credentials['client_secret'];

        return $this;
    }

    public function generateAccessToken() {
        return cache()->remember('spotify_access_token', 3600, function () {
            $session = new Session(
                $this->client_id,
                $this->client_secret
            );

            $session->requestCredentialsToken();
            
            return $session->getAccessToken();
        });
    }

    public function getSpotifyApi() {
        $accessToken = $this->generateAccessToken();

        $api = new SpotifyWebAPI();

        $api->setAccessToken($accessToken);

        return $api;
    }

    // search

    public function search($q,$type,$options=[]) {

        $api = $this->getSpotifyApi();

        return $api->search($q,$type,$options);

    }

    // load playlist 

    public function playlist($id,$options=[]) {

        $api = $this->getSpotifyApi();

        $playlist = $api->getPlaylist($id,$options);
        
        return $playlist;

    }
}
