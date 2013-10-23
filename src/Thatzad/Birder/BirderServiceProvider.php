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
		App::register('DotZecker\Larafeed\LarafeedServiceProvider');

		$this->app['birder'] = $this->app->share(function($app)
        {
        	$config = array(
				'consumer_key'    => Config::get('birder::twitter.consumer_key'),
				'consumer_secret' => Config::get('birder::twitter.consumer_secret'),
				'token'           => Config::get('birder::twitter.access_token'),
				'secret'          => Config::get('birder::twitter.access_token_secret'),
				'use_ssl'         => Config::get('birder::twitter.use_ssl')
        	);

        	// Set the Twitter api version
        	Config::set('twitter::API_VERSION', '1.1');

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
