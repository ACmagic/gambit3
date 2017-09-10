<?php namespace Modules\Customer\Providers;

use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Modules\Customer\Auth\CustomersProvider;
use Modules\Customer\Contracts\Context\CustomerPool as CustomerPoolContract;
use Modules\Customer\Contracts\Context\Customer as CustomerContract;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Customer\Context\Resolver\CustomerPoolResolver;
use Modules\Customer\Context\Resolver\CustomerResolver;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerPoolRepository;
use Modules\Customer\Repositories\Doctrine\DoctrineCustomerRepository;
use Modules\Customer\Repositories\Doctrine\DoctrineCustomerPoolRepository;
use Modules\Customer\Entities\Customer as CustomerEntity;
use Modules\Customer\Entities\CustomerPool as CustomerPoolEntity;
use Modules\Customer\Http\ViewComposers\Admin\Customer\DataGridComposer as CustomerDataGridComposer;

class CustomerServiceProvider extends ServiceProvider {

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
		$this->extendAuthManager();
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

		$this->app->bind(CustomerPoolContract::class,function($app) {
			return $app['context.manager']->getActiveContext('customer_pool');
		});
		$this->app->singleton(CustomerPoolResolver::class);

		$this->app->bind(CustomerContract::class,function($app) {
			return $app['context.manager']->getActiveContext('customer');
		});
		$this->app->singleton(CustomerResolver::class);

		// Tag resolvers.
		$this->app->tag([CustomerPoolResolver::class,CustomerResolver::class], 'context_resolver');

		$this->app->bind(CustomerRepository::class,function($app) {
			return new DoctrineCustomerRepository(
				EntityManager::getRepository(CustomerEntity::class)
			);
		});

		$this->app->bind(CustomerPoolRepository::class,function() {
			return new DoctrineCustomerPoolRepository(
				EntityManager::getRepository(CustomerPoolEntity::class)
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
		    __DIR__.'/../Config/config.php' => config_path('customer.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'customer'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/customer');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/customer';
		}, \Config::get('view.paths')), [$sourcePath]), 'customer');


		// View composers
		view()->composer('customer::admin.customer.datagrid',CustomerDataGridComposer::class);
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/customer');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'customer');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'customer');
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

	/**
	 * Extend the auth manager
	 */
	protected function extendAuthManager()
	{
		$this->app->make('auth')->provider('customers', function ($app, $config) {

			$entity = $config['model'];

			$em = $app['registry']->getManagerForClass($entity);

			if (!$em) {
				throw new InvalidArgumentException("No EntityManager is set-up for {$entity}");
			}

			return new CustomersProvider(
				$app['hash'],
				$em,
				$entity
			);
		});
	}

}
