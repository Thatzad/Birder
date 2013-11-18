<?php namespace Thatzad\Birder;

use App;
use Config;
use Illuminate\Support\ServiceProvider;

class BirderServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('thatzad/birder');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
    	// Larafeed Service Provider
    	$this->app->register('DotZecker\Larafeed\LarafeedServiceProvider');

        $this->app['birder'] = $this->app->share(function($app)
        {

        	$birderConfig = $app['config']['birder::twitter'];
        	$config = array(
				'consumer_key'    => $birderConfig['consumer_key'],
				'consumer_secret' => $birderConfig['consumer_secret'],
				'token'           => $birderConfig['access_token'],
				'secret'          => $birderConfig['access_token_secret'],
				'use_ssl'         => $birderConfig['use_ssl']
        	);

        	// Set the Twitter api version
        	// I don't like to do this, but that package was build by this way...
        	$app['config']['twitter::API_VERSION'] = '1.1';

            return new Birder(new \Thujohn\Twitter\Twitter($config));
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
