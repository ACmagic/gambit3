<?php namespace Modules\Football\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Football\Entities\NFLTeam as NFLTeamEntity;
use Modules\Football\Repositories\NFLTeamRepository;
use Modules\Football\Repositories\Doctrine\DoctrineNFLTeamRepository;

class FootballServiceProvider extends ServiceProvider {

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

		$this->app->bind(NFLTeamRepository::class,function() {
			return new DoctrineNFLTeamRepository(
				EntityManager::getRepository(NFLTeamEntity::class)
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
		    __DIR__.'/../Config/config.php' => config_path('football.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'football'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/football');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/football';
		}, \Config::get('view.paths')), [$sourcePath]), 'football');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/football');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'football');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'football');
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
