<?php namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Core\Context\ContextManager;
use Modules\Core\Context\ContextResolver;
use Laravel\Passport\Passport;
use League\Fractal\Manager as FractalManager;
use Illuminate\Support\Facades\Event;
use Mesour\Components\Application\IApplication;
use Mesour\UI\Application as UiApplication;
use Mesour\Components\Application\Request as UiRequest;
use Modules\Core\Subscribers\RoutingSubscriber;
use Payum\Core\PayumBuilder;
use Modules\Core\Contracts\Context\Site as SiteContract;
use Modules\Core\Contracts\Context\Store as StoreContract;
use Modules\Core\Context\Resolver\SiteResolver;
use Modules\Core\Context\Resolver\StoreResolver;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Repositories\SiteRepository;
use Modules\Core\Repositories\StoreRepository;
use Modules\Core\Repositories\Doctrine\DoctrineUserRepository;
use Modules\Core\Repositories\Doctrine\DoctrineSiteRepository;
use Modules\Core\Repositories\Doctrine\DoctrineStoreRepository;
use Modules\Core\Entities\User as UserEntity;
use Modules\Core\Entities\Site as SiteEntity;
use Modules\Core\Entities\Store as StoreEntity;
use Modules\Core\Http\ViewComposers\Admin\Site\DataGridComposer as SiteDataGridComposer;
use Modules\Core\Http\ViewComposers\Admin\User\DataGridComposer as UserDataGridComposer;
use Modules\Core\Http\ViewComposers\Admin\Store\DataGridComposer as StoreDataGridComposer;

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

		// Passport integration
        Passport::routes();

        // Register subscribers.
        Event::subscribe(RoutingSubscriber::class);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		/*$this->app->singleton(IApplication::class,function() {
			$theApp = new UiApplication();
			$theApp->setRequest($_REQUEST);
			return $theApp;
		});
		$this->app->alias(IApplication::class,'uiapp');*/

		Passport::ignoreMigrations();

		$this->app->singleton('context.resolver',function($app) {
			$resolvers = $app->tagged('context_resolver');
			$resolver = new ContextResolver($resolvers);
			return $resolver;
		});

		$this->app->singleton('context.manager',function($app) {
			return new ContextManager($app['context.resolver']);
		});

		$this->app->bind(StoreContract::class,function($app) {
			return $app['context.manager']->getActiveContext('store');
		});

		$this->app->bind(SiteContract::class,function($app) {
			return $app['context.manager']->getActiveContext('site');
		});

		$this->app->singleton(SiteResolver::class);
		$this->app->singleton(StoreResolver::class);
		$this->app->tag([SiteResolver::class, StoreResolver::class], 'context_resolver');

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

		$this->app->bind(StoreRepository::class,function() {
			return new DoctrineStoreRepository(
				EntityManager::getRepository(StoreEntity::class)
			);
		});

		// Payum
		$this->app->resolving('payum.builder', function(PayumBuilder $payumBuilder) {

			$payumBuilder
				// this method registers filesystem storages, consider to change them to something more
				// sophisticated, like eloquent storage
				->addDefaultStorages()

				// @todo: Hard code for now.
				->addGateway('paypal_ec', [
					'factory' => 'paypal_express_checkout',
					'username' => 'sme.s.key-facilitator_api1.gmail.com',
					'password' => '1368053213',
					'signature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31Am72MgoxdyL7fUjtAGEW1dNhV1Nc',
					'sandbox' => true
				]);
				/*->addGateway('paypal_pc', [
					'factory' => 'paypal_pro_checkout',
        			'username' => 'sme.s.key-facilitator_api1.gmail.com',
        			'password' => '1368053213',
					'partner' => 'REPLACE IT',
        			'vendor' => 'REPLACE IT',
        			'sandbox' => true
				]);*/

		});

		// Fractal manager
        $this->app->singleton(FractalManager::class);

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

		// View composers
		view()->composer('core::admin.site.datagrid',SiteDataGridComposer::class);
		view()->composer('core::admin.user.datagrid',UserDataGridComposer::class);
		view()->composer('core::admin.store.datagrid',StoreDataGridComposer::class);
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
