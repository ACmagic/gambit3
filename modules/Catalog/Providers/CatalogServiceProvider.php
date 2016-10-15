<?php namespace Modules\Catalog\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Catalog\Entities\Side as SideEntity;
use Modules\Catalog\Entities\Line as LineEntity;
use Modules\Catalog\Entities\LineWorkflowState as LineWorkflowStateEntity;
use Modules\Catalog\Entities\InverseLine as InverseLineEntity;
use Modules\Catalog\Entities\AdvertisedLine as AdvertisedLineEntity;
use Modules\Catalog\Entities\AcceptedLine as AcceptedLineEntity;
use Modules\Catalog\Repositories\SideRepository;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Repositories\LineWorkflowStateRepository;
use Modules\Catalog\Repositories\InverseLineRepository;
use Modules\Catalog\Repositories\AdvertisedLineRepository;
use Modules\Catalog\Repositories\AcceptedLineRepository;
use Modules\Catalog\Repositories\Doctrine\DoctrineSideRepository;
use Modules\Catalog\Repositories\Doctrine\DoctrineLineRepository;
use Modules\Catalog\Repositories\Doctrine\DoctrineLineWorkflowStateRepository;
use Modules\Catalog\Repositories\Doctrine\DoctrineInverseLineRepository;
use Modules\Catalog\Repositories\Doctrine\DoctrineAdvertisedLineRepository;
use Modules\Catalog\Repositories\Doctrine\DoctrineAcceptedLineRepository;
use Modules\Catalog\Http\ViewComposers\Admin\Line\DataGridComposer as LineDataGridComposer;
use Modules\Catalog\Http\ViewComposers\Admin\AdvertisedLine\DataGridComposer as AdvertisedLineDataGridComposer;
use Modules\Catalog\Http\ViewComposers\Admin\AcceptedLine\DataGridComposer as AcceptedLineDataGridComposer;
use Modules\Prediction\Contracts\PredictionTypeManager as IPredictionTypeManager;
use Doctrine\ORM\EntityManagerInterface;
use Modules\Prediction\Contracts\PredictableManager as IPredictableManager;

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

		$this->app->bind(LineRepository::class,function($app) {
			return new DoctrineLineRepository(
			    $app[EntityManagerInterface::class],
				EntityManager::getRepository(LineEntity::class),
				$app[IPredictionTypeManager::class]
			);
		});

        $this->app->bind(LineWorkflowStateRepository::class,function($app) {
            return new DoctrineLineWorkflowStateRepository(
                EntityManager::getRepository(LineWorkflowStateEntity::class),
                $app[IPredictionTypeManager::class]
            );
        });

        $this->app->bind(InverseLineRepository::class,function($app) {
            return new DoctrineInverseLineRepository(
                EntityManager::getRepository(InverseLineEntity::class),
                $app[IPredictionTypeManager::class],
                $app[LineWorkflowStateRepository::class],
                $app[IPredictableManager::class],
                $app[IPredictionTypeManager::class]
            );
        });

		$this->app->bind(AdvertisedLineRepository::class,function($app) {
			return new DoctrineAdvertisedLineRepository(
                $app[EntityManagerInterface::class],
				EntityManager::getRepository(AdvertisedLineEntity::class)
			);
		});

		$this->app->bind(AcceptedLineRepository::class,function() {
			return new DoctrineAcceptedLineRepository(
				EntityManager::getRepository(AcceptedLineEntity::class)
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
		view()->composer('catalog::admin.accepted_line.datagrid',AcceptedLineDataGridComposer::class);
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
