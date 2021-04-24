<?php

namespace HackerESQ\LaravelSpotify;

use SpotifyWebAPI\Session;
use Illuminate\Support\Arr;
use SpotifyWebAPI\SpotifyWebAPI;
use Illuminate\Support\Facades\Cache;

class Spotify
{

    protected string $client_id = '';
    protected string $client_secret = '';

    public function __construct($config)
    {
        $this->client_id = Arr::get($config, 'spotify.client_id', null);
        $this->client_secret = Arr::get($config, 'spotify.client_secret', null);
    }

    public function setCredentials($credentials)
    {
        $this->client_id = $credentials['client_id'];
        $this->client_secret = $credentials['client_secret'];

        return $this;
    }

    public function forgetAccessToken()
    {
        Cache::forget('spotify_access_token');
    }

    public function generateAccessToken()
    {
        return Cache::remember('spotify_access_token', 3600, function () {
            $session = new Session(
                $this->client_id,
                $this->client_secret
            );

            $session->requestCredentialsToken();

            return $session->getAccessToken();
        });
    }

    public function getSpotifyApi()
    {
        $accessToken = $this->generateAccessToken();

        $api = new SpotifyWebAPI();

        $api->setAccessToken($accessToken);

        return $api;
    }

    // search

    public function search($q, $type, $options = [])
    {

        $api = $this->getSpotifyApi();

        return $api->search($q, $type, $options);
    }

    // load playlist 

    public function playlist($id, $options = [])
    {

        $api = $this->getSpotifyApi();

        $playlist = $api->getPlaylist($id, $options);

        return $playlist;
    }
}
