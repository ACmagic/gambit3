<?php namespace Modules\Sales\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Sales\Entities\Quote as QuoteEntity;
use Modules\Sales\Repositories\QuoteRepository;
use Modules\Sales\Repositories\Doctrine\DoctrineQuoteRepository;
use Modules\Sales\Entities\SaleItem as SaleItemEntity;
use Modules\Sales\Repositories\SaleItemRepository;
use Modules\Sales\Repositories\Doctrine\DoctrineSaleItemRepository;
use Modules\Sales\Entities\SaleAdvertisedLine as SaleAdvertisedLineEntity;
use Modules\Sales\Repositories\SaleAdvertisedLineRepository;
use Modules\Sales\Repositories\Doctrine\DoctrineSaleAdvertisedLineRepository;
use Modules\Sales\Entities\SaleWorkflowState as SaleWorkflowStateEntity;
use Modules\Sales\Entities\SaleItemWorkflowState as SaleItemWorkflowStateEntity;
use Modules\Sales\Repositories\SaleWorkflowStateRepository;
use Modules\Sales\Repositories\SaleItemWorkflowStateRepository;
use Modules\Sales\Repositories\Doctrine\DoctrineSaleWorkflowStateRepository;
use Modules\Sales\Repositories\Doctrine\DoctrineSaleItemWorkflowStateRepository;

class SalesServiceProvider extends ServiceProvider {

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

		$this->app->bind(QuoteRepository::class,function() {
			return new DoctrineQuoteRepository(
				EntityManager::getRepository(QuoteEntity::class)
			);
		});

		$this->app->bind(SaleWorkflowStateRepository::class,function() {
			return new DoctrineSaleWorkflowStateRepository(
				EntityManager::getRepository(SaleWorkflowStateEntity::class)
			);
		});

        $this->app->bind(SaleItemWorkflowStateRepository::class,function() {
            return new DoctrineSaleItemWorkflowStateRepository(
                EntityManager::getRepository(SaleItemWorkflowStateEntity::class)
            );
        });

		$this->app->bind(SaleItemRepository::class,function() {
			return new DoctrineSaleItemRepository(
				EntityManager::getRepository(SaleItemEntity::class)
			);
		});

		$this->app->bind(SaleAdvertisedLineRepository::class,function() {
			return new DoctrineSaleAdvertisedLineRepository(
				EntityManager::getRepository(SaleAdvertisedLineEntity::class)
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
		    __DIR__.'/../Config/config.php' => config_path('sales.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'sales'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/sales');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/sales';
		}, \Config::get('view.paths')), [$sourcePath]), 'sales');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/sales');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'sales');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'sales');
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
