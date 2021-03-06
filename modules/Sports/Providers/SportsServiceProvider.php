<?php namespace Modules\Sports\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Sports\Entities\Team as TeamEntity;
use Modules\Sports\Repositories\TeamRepository;
use Modules\Sports\Repositories\Doctrine\DoctrineTeamRepository;
use Modules\Sports\Entities\Game as GameEntity;
use Modules\Sports\Repositories\GameRepository;
use Modules\Sports\Repositories\Doctrine\DoctrineGameRepository;

class SportsServiceProvider extends ServiceProvider {

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

		$this->app->bind(TeamRepository::class,function() {
			return new DoctrineTeamRepository(
				EntityManager::getRepository(TeamEntity::class)
			);
		});

		$this->app->bind(GameRepository::class,function() {
			return new DoctrineGameRepository(
				EntityManager::getRepository(GameEntity::class)
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
		    __DIR__.'/../Config/config.php' => config_path('sports.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'sports'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/sports');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/sports';
		}, \Config::get('view.paths')), [$sourcePath]), 'sports');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/sports');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'sports');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'sports');
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
