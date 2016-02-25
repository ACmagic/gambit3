<?php namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Repositories\SiteRepository;
use Modules\Core\Repositories\Doctrine\DoctrineUserRepository;
use Modules\Core\Repositories\Doctrine\DoctrineSiteRepository;
use Modules\Core\Entities\User as UserEntity;
use Modules\Core\Entities\Site as SiteEntity;

class CoreServiceProvider extends ServiceProvider {

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

		$this->app->bind(UserRepository::class,function() {
			return new DoctrineUserRepository(
				EntityManager::getRepository(UserEntity::class)
			);
		});

		$this->app->bind(SiteRepository::class,function() {
			return new DoctrineSiteRepository(
				EntityManager::getRepository(SiteEntity::class)
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
		    __DIR__.'/../Config/config.php' => config_path('core.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'core'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/core');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/core';
		}, \Config::get('view.paths')), [$sourcePath]), 'core');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/core');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'core');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'core');
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
