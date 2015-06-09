<?php namespace Illuminate3\Admin;

use Illuminate\Support\ServiceProvider;
use Route, View, Artisan, Schema, Config, Redirect;

class AdminServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		Config::package('illuminate3/admin', 'admin');
	}

	public function boot()
	{
		$this->package('illuminate3/admin', 'admin');
		$this->app->register('Illuminate3\Matcher\MatcherServiceProvider');
	}
        
    /**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('admin');
	}

}