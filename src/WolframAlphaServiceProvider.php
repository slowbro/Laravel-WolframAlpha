<?php namespace ConnorVG\WolframAlpha;

use Illuminate\Support\ServiceProvider;

class WolframAlphaServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('connorvg/wolframalpha');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerWolframAlpha(); 
	}

	/**
	 * Register the application bindings.
	 *
	 * @return void
	 */
	protected function registerWolframAlpha()
	{
		$this->app->bind('wolframalpha', function($app)
		{
			return new WolframAlpha($app['config']->get('app.wolframapikey'));
		});
	}
}