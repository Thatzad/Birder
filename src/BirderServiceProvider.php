<?php namespace Thatzad\Birder;

use App;
use Config;
use Illuminate\Support\ServiceProvider;
use Thujohn\Twitter\Twitter;

class BirderServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/birder.php' => config_path('birder.php'),
        ]);
    }

    public function register()
    {
        $this->app->register('DotZecker\Larafeed\LarafeedServiceProvider');

        $this->app['birder'] = $this->buildBirder(config('birder'));
    }

    private function buildBirder($birderConfig)
    {
        $config = [
            'consumer_key'    => $birderConfig['consumer_key'],
            'consumer_secret' => $birderConfig['consumer_secret'],
            'token'           => $birderConfig['access_token'],
            'secret'          => $birderConfig['access_token_secret'],
            'use_ssl'         => $birderConfig['use_ssl']
        ];

        return new Birder(new Twitter($config));
    }
}
