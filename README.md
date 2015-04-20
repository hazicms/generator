Laravel API Generator Extend

Steps to Get Started
---------------------

1. Add this package to your composer.json:
  
        "require": {
            "pingpong/generators": "2.0.*@dev",
            "pingpong/modules": "2.0.x-dev",
            "aitiba/laravelapigeneratorextend": "dev-master"
        }
  
2. Run composer update

        composer update
    
3. Add the ServiceProviders to the providers array in ```config/app.php```.<br>
   As we are using these two packages [illuminate/html](https://github.com/illuminate/html) & [laracasts/flash](https://github.com/laracasts/flash) as a dependency.<br>
   so we need to add those ServiceProviders as well.

        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Laracasts\Flash\FlashServiceProvider',
        'Mitul\Generator\GeneratorServiceProvider',
        'Pingpong\Modules\ModulesServiceProvider',
        'Aitiba\LaravelApiGeneratorExtend\Generator\GeneratorServiceProvider',

   Also for convenience, add these facades in alias array in ```config/app.php```.

        'Module'=> 'Pingpong\Modules\Facades\Module',
        'Form'  => 'Illuminate\Html\FormFacade',
        'HTML'  => 'Illuminate\Html\HtmlFacade',
        'Flash' => 'Laracasts\Flash\Flash'

4. Publish ```generator.php``` and ```modules.php```

        php artisan vendor:publish --provider="Aitiba\LaravelApiGeneratorExtend\Generator\GeneratorServiceProvider"

        php artisan vendor:publish

5. Modify ```modules.php``` file to your needs.On Cms, change 'namespace' => 'Cms\Modules', and 'modules' => app_path('Modules').

6. Modify ```generator.php``` file to your needs.

7. Fire artisan command to generate module with model.

        php artisan mitul.generator:module_model ModuleName ModelName
        
    e.g.
    
        php artisan mitul.generator:module_model Network Project
        php artisan mitul.generator:module_model Blog Post
 
8. Enter the fields with options<br>

9. And you are ready to go. :)