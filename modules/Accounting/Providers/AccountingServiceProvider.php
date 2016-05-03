<?php namespace Modules\Accounting\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Accounting\Entities\AccountType as AccountTypeEntity;
use Modules\Accounting\Repositories\AccountTypeRepository;
use Modules\Accounting\Repositories\Doctrine\DoctrineAccountTypeRepository;
use Modules\Accounting\Entities\PostingEvent as PostingEventEntity;
use Modules\Accounting\Repositories\PostingEventRepository;
use Modules\Accounting\Repositories\Doctrine\DoctrinePostingEventRepository;
use Modules\Accounting\Entities\AssetType as AssetTypeEntity;
use Modules\Accounting\Repositories\AssetTypeRepository;
use Modules\Accounting\Repositories\Doctrine\DoctrineAssetTypeRepository;
use Modules\Accounting\Entities\Account as AccountEntity;
use Modules\Accounting\Repositories\AccountRepository;
use Modules\Accounting\Repositories\Doctrine\DoctrineAccountRepository;

class AccountingServiceProvider extends ServiceProvider {

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

		$this->app->bind(AccountTypeRepository::class,function() {
			return new DoctrineAccountTypeRepository(
				EntityManager::getRepository(AccountTypeEntity::class)
			);
		});

		$this->app->bind(PostingEventRepository::class,function() {
			return new DoctrinePostingEventRepository(
				EntityManager::getRepository(PostingEventEntity::class)
			);
		});

		$this->app->bind(AssetTypeRepository::class,function() {
			return new DoctrineAssetTypeRepository(
				EntityManager::getRepository(AssetTypeEntity::class)
			);
		});

		$this->app->bind(AccountRepository::class,function() {
			return new DoctrineAccountRepository(
				EntityManager::getRepository(AccountEntity::class)
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
		    __DIR__.'/../Config/config.php' => config_path('accounting.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'accounting'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/accounting');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/accounting';
		}, \Config::get('view.paths')), [$sourcePath]), 'accounting');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/accounting');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'accounting');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'accounting');
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
