<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator;

use Illuminate\Support\ServiceProvider;
// use Mitul\Generator\Commands\APIGeneratorCommand;
// use Mitul\Generator\Commands\ScaffoldAPIGeneratorCommand;
// use Mitul\Generator\Commands\ScaffoldGeneratorCommand;

class GeneratorServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// dd("pasa");
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
 
 	// 	$this->app->singleton('mitul.generator.scaffold_api', function ($app)
		// {
		// 	return new ScaffoldAPIGeneratorCommand();
		// });

		$this->app->singleton(
			'Illuminate\Contracts\Debug\ExceptionHandler',
			'Mitul\Generator\Exceptions\APIExceptionsHandler'
		);

	    $this->commands(['laravelapigeneratorextend.generator']);
	}

}
