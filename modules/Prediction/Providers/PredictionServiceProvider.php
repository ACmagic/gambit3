<?php namespace Modules\Prediction\Providers;

use Illuminate\Support\ServiceProvider;

use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Prediction\Entities\Prediction as PredictionEntity;
use Modules\Prediction\Repositories\PredictionRepository;
use Modules\Prediction\Repositories\Doctrine\DoctrinePredictionRepository;
use Modules\Prediction\PredictionTypeManager;
use Modules\Prediction\PredictableManager;
use Modules\Prediction\Contracts\PredictableManager as IPredictableManager;
use Modules\Prediction\Contracts\PredictionTypeManager as IPredictionTypeManager;

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

		// Maintains prediction types.
		$this->app->singleton('prediction.type.manager',function($app) {
			$types = $app->tagged('prediction_type');
			$manager = new PredictionTypeManager($types);
			return $manager;
		});

		$this->app->bind(IPredictionTypeManager::class,function($app) {
			return $app['prediction.type.manager'];
		});

		// Managers items that one can make a prediction one.
		$this->app->singleton('predictable.manager',function($app) {
			$types = $app->tagged('predictable_resolver');
			$manager = new PredictableManager($types);
			return $manager;
		});

		$this->app->bind(IPredictableManager::class,function($app) {
			return $app['predictable.manager'];
		});

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
