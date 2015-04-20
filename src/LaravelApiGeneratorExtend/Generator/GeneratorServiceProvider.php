<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator;

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
		]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('laravelapigeneratorextend.generator', function ($app)
        {
            return new Commands\ModuleModelGeneratorCommand();
        });
 
		$this->app->singleton(
			'Illuminate\Contracts\Debug\ExceptionHandler',
			'Mitul\Generator\Exceptions\APIExceptionsHandler'
		);

	    $this->commands(['laravelapigeneratorextend.generator']);
	}

}
