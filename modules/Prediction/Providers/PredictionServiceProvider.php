<?php namespace Modules\Prediction\Providers;

use Illuminate\Support\ServiceProvider;

use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Prediction\Entities\Prediction as PredictionEntity;
use Modules\Prediction\Repositories\PredictionRepository;
use Modules\Prediction\Repositories\Doctrine\DoctrinePredictionRepository;

class PredictionServiceProvider extends ServiceProvider {

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

		$this->app->bind(PredictionRepository::class,function() {
			return new DoctrinePredictionRepository(
				EntityManager::getRepository(PredictionEntity::class)
			);
		});

	}

	/**
	 * Register config.
	 * 
	 * @return void
	 */
	protected function registerConfig()
	{
		$this->publishes([
		    __DIR__.'/../Config/config.php' => config_path('prediction.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'prediction'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/prediction');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/prediction';
		}, \Config::get('view.paths')), [$sourcePath]), 'prediction');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/prediction');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'prediction');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'prediction');
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
