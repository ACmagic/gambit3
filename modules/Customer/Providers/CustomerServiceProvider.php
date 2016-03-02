<?php namespace Modules\Customer\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\Doctrine\DoctrineCustomerRepository;
use Modules\Customer\Entities\Customer as CustomerEntity;
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

		$this->app->bind(CustomerRepository::class,function() {
			return new DoctrineCustomerRepository(
				EntityManager::getRepository(CustomerEntity::class)
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

}
