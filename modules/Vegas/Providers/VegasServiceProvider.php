<?php namespace Modules\Vegas\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Vegas\Prediction\Type\MoneyLineType as MoneyLinePredictionType;
use Modules\Vegas\Prediction\Type\PointSpreadType as PointSpreadPredictionType;
use Modules\Sports\Repositories\GameRepository;
use Modules\Sports\Repositories\TeamRepository;

class VegasServiceProvider extends ServiceProvider {

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

		// Register prediction types
		$this->app->singleton(MoneyLinePredictionType::class);

		$this->app->singleton(PointSpreadPredictionType::class,function($app) {
			$type = new PointSpreadPredictionType($app['laravel-form-builder'],$app['view']);
			$type->injectGameRepo($app[GameRepository::class]);
			$type->injectTeamRepo($app[TeamRepository::class]);
			return $type;
		});
		$this->app->tag([MoneyLinePredictionType::class,PointSpreadPredictionType::class], 'prediction_type');

	}

	/**
	 * Register config.
	 * 
	 * @return void
	 */
	protected function registerConfig()
	{
		$this->publishes([
		    __DIR__.'/../Config/config.php' => config_path('vegas.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'vegas'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/vegas');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/vegas';
		}, \Config::get('view.paths')), [$sourcePath]), 'vegas');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/vegas');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'vegas');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'vegas');
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
