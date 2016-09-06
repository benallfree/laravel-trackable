<?php namespace BenAllfree\Trackable;

use Illuminate\Support\ServiceProvider;

class TrackableServiceProvider extends ServiceProvider {

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
    $this->publishes([
      __DIR__.'/../../publish/config/trackable.php' => config_path('trackable.php'),
    ]);
    if (! $this->app->routesAreCached())
    {
      require __DIR__.'/routes.php';
    }
    $this->loadViewsFrom(__DIR__.'/views', 'trackable');
    $this->loadMigrationsFrom(__DIR__.'/../../publish/migrations');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
    $this->mergeConfigFrom(
        __DIR__.'/../../publish/config/trackable.php', 'trackable'
    );
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
