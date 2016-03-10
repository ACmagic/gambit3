<?php namespace Modules\Catalog\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Catalog\Entities\Side as SideEntity;
use Modules\Catalog\Entities\Line as LineEntity;
use Modules\Catalog\Entities\AdvertisedLine as AdvertisedLineEntity;
use Modules\Catalog\Repositories\SideRepository;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Repositories\AdvertisedLineRepository;
use Modules\Catalog\Repositories\Doctrine\DoctrineSideRepository;
use Modules\Catalog\Repositories\Doctrine\DoctrineLineRepository;
use Modules\Catalog\Repositories\Doctrine\DoctrineAdvertisedLineRepository;
use Modules\Catalog\Http\ViewComposers\Admin\Line\DataGridComposer as LineDataGridComposer;
use Modules\Catalog\Http\ViewComposers\Admin\AdvertisedLine\DataGridComposer as AdvertisedLineDataGridComposer;

class CatalogServiceProvider extends ServiceProvider {

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

		$this->app->bind(SideRepository::class,function() {
			return new DoctrineSideRepository(
				EntityManager::getRepository(SideEntity::class)
			);
		});

		$this->app->bind(LineRepository::class,function() {
			return new DoctrineLineRepository(
				EntityManager::getRepository(LineEntity::class)
			);
		});

		$this->app->bind(AdvertisedLineRepository::class,function() {
			return new DoctrineAdvertisedLineRepository(
				EntityManager::getRepository(AdvertisedLineEntity::class)
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
		    __DIR__.'/../Config/config.php' => config_path('catalog.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'catalog'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/catalog');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/catalog';
		}, \Config::get('view.paths')), [$sourcePath]), 'catalog');

		// View composers
		view()->composer('catalog::admin.line.datagrid',LineDataGridComposer::class);
		view()->composer('catalog::admin.advertised_line.datagrid',AdvertisedLineDataGridComposer::class);
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/catalog');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'catalog');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'catalog');
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
