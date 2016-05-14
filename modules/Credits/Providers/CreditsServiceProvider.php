<?php namespace Modules\Credits\Providers;

use Illuminate\Support\ServiceProvider;
use Payum\Core\PayumBuilder;
use Modules\Credits\Payum\Credit\CreditGatewayFactory;

class CreditsServiceProvider extends ServiceProvider {

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

		// Change of heart with this.
		/*$this->app->resolving('payum.builder', function(PayumBuilder $payumBuilder) {

			$payumBuilder
				// Register custom factory for gambit gateway.
				->addGatewayFactory('gambit_credit', function($config, $coreGateway) {
    				return new CreditGatewayFactory($config, $coreGateway);
				})
				// Make gambit credit gateway available.
				->addGateway('gambit_credit', [
					'factory' => 'gambit_credit',
				]);

		});*/

	}

	/**
	 * Register config.
	 * 
	 * @return void
	 */
	protected function registerConfig()
	{
		$this->publishes([
		    __DIR__.'/../Config/config.php' => config_path('credits.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'credits'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/credits');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/credits';
		}, \Config::get('view.paths')), [$sourcePath]), 'credits');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/credits');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'credits');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'credits');
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
