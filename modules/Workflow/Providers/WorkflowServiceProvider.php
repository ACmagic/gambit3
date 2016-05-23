<?php namespace Modules\Workflow\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Workflow\Repositories\WorkflowRepository;
use Modules\Workflow\Repositories\Doctrine\DoctrineWorkflowRepository;
use Modules\Workflow\Entities\Workflow as WorkflowEntity;
use Modules\Workflow\Repositories\StateRepository;
use Modules\Workflow\Repositories\Doctrine\DoctrineStateRepository;
use Modules\Workflow\Entities\State as StateEntity;
use Modules\Workflow\Repositories\TransitionRepository;
use Modules\Workflow\Repositories\Doctrine\DoctrineTransitionRepository;
use Modules\Workflow\Entities\Transition as TransitionEntity;
use LaravelDoctrine\ORM\Facades\EntityManager;

class WorkflowServiceProvider extends ServiceProvider {

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

		$this->app->bind(WorkflowRepository::class,function() {
			return new DoctrineWorkflowRepository(
				EntityManager::getRepository(WorkflowEntity::class)
			);
		});

		$this->app->bind(StateRepository::class,function() {
			return new DoctrineStateRepository(
				EntityManager::getRepository(StateEntity::class)
			);
		});

		$this->app->bind(TransitionRepository::class,function() {
			return new DoctrineTransitionRepository(
				EntityManager::getRepository(TransitionEntity::class)
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
		    __DIR__.'/../Config/config.php' => config_path('workflow.php'),
		]);
		$this->mergeConfigFrom(
		    __DIR__.'/../Config/config.php', 'workflow'
		);
	}

	/**
	 * Register views.
	 * 
	 * @return void
	 */
	public function registerViews()
	{
		$viewPath = base_path('resources/views/modules/workflow');

		$sourcePath = __DIR__.'/../Resources/views';

		$this->publishes([
			$sourcePath => $viewPath
		]);

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
			return $path . '/modules/workflow';
		}, \Config::get('view.paths')), [$sourcePath]), 'workflow');
	}

	/**
	 * Register translations.
	 * 
	 * @return void
	 */
	public function registerTranslations()
	{
		$langPath = base_path('resources/lang/modules/workflow');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'workflow');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'workflow');
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
