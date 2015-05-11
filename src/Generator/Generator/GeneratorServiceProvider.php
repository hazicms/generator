<?php namespace HaziCms\Generator\Generator;

use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$configPath = __DIR__ . '/../Config/generator.php';
		$this->publishes([$configPath => config_path('generator.php')], 'config');
		$this->publishes([
			__DIR__.'/../Views/Common' => base_path('resources/views'),
			__DIR__.'/../Config/Public' => base_path('public'),
			__DIR__.'/../Config/Views' => base_path('resources/views')
		]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('hazicms.generator', function ($app)
        {
            return new Commands\ModuleModelGeneratorCommand();
        });
 
	    $this->commands(['hazicms.generator']);
	}

}
