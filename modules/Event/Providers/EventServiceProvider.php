<?php namespace Modules\Event\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Event\Entities\Category as CategoryEntity;
use Modules\Event\Entities\Event as EventEntity;
use Modules\Event\Repositories\CategoryRepository;
use Modules\Event\Repositories\EventRepository;
use Modules\Event\Repositories\Doctrine\DoctrineCategoryRepository;
use Modules\Event\Repositories\Doctrine\DoctrineEventRepository;

class EventServiceProvider extends ServiceProvider {

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

		$this->app->bind(CategoryRepository::class,function() {
			return new DoctrineCategoryRepository(
				EntityManager::getRepository(CategoryEntity::class)
			);
		});

		$this->app->bind(EventRepository::class,function() {
			return new DoctrineEventRepository(
				EntityManager::getRepository(EventEntity::class)
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
		    __DIR__.'/../Config/config.php' => config_path('event.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'event'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/event');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/event';
		}, \Config::get('view.paths')), [$sourcePath]), 'event');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/event');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'event');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'event');
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
