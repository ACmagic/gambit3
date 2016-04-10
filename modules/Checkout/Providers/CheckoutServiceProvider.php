<?php namespace Modules\Checkout\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Checkout\Context\Resolver\CartResolver;
use Modules\Checkout\Contracts\Context\Cart as CartContract;

class CheckoutServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Boot the application events.
	 * 
	 * @return void
	 */
	public function boot()
	{
		$this->registerTranslations();
		$this->registerConfig();
		$this->registerViews();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app->bind(CartContract::class,function($app) {
			return $app['context.manager']->getActiveContext('cart');
		});

		$this->app->singleton(CartResolver::class);
		$this->app->tag([CartResolver::class], 'context_resolver');

	}

	/**
	 * Register config.
	 * 
	 * @return void
	 */
	protected function registerConfig()
	{
		$this->publishes([
		    __DIR__.'/../Config/config.php' => config_path('checkout.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'checkout'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/checkout');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/checkout';
		}, \Config::get('view.paths')), [$sourcePath]), 'checkout');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/checkout');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'checkout');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'checkout');
		}
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
