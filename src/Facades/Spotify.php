<?php 

namespace HackerESQ\LaravelSpotify\Facades;

use Illuminate\Support\Facades\Facade;

class Spotify extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'spotify';
    }
}
