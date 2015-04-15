<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Commands;

use Illuminate\Console\Command;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Utils\CommandData;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module\ModuleMigrationGenerator;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module\ModuleModelGenerator;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module\ModuleRepositoryGenerator;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module\ModuleRequestGenerator;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module\ModuleRoutesGenerator;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module\ModuleRepoViewControllerGenerator;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module\ModuleViewControllerGenerator;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module\ModuleViewGenerator;
use Symfony\Component\Console\Input\InputArgument;
use \Config;
use \File;

class ModuleModelGeneratorCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mitul.generator:module_model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a module with a model';

    /**
     * The command Data
     *
     * @var CommandData
     */
    public $commandData;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_SCAFFOLD);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
   //     dd("entra");
        $this->commandData->moduleName = $this->argument('module');
        // dd($this->commandData->moduleName);
        $this->commandData->modelName = $this->argument('model');
        $fileHelper = new \Aitiba\LaravelApiGeneratorExtend\Generator\File\FileHelper();
        // dd($fileHelper->moduleExists($name));
        if (! $fileHelper->moduleExists($this->commandData->moduleName)) {
            $fileHelper->makeModuleStructure($this->commandData->moduleName);
        } else {
            echo ('MODULE EXISTS... Great! Less work! :-)');
        }

        // crear el CRUD de $name
        // $tmpPath = '/var/www/myblog/storage/app/laravel-generator/'.$this->commandData->modelName;
        // File::makeDirectory($tmpPath, 0777, true, true);
        // \Artisan::call('mitul.generator:scaffold', ['model' => $this->commandData->modelName]);
        $this->getData();
    }

    private function getData()
    {
        $this->commandData->initVariables();
        $this->commandData->inputFields = $this->commandData->getInputFields();

        $followRepoPattern = $this->confirm("\nDo you want to generate repository ? (y|N)", false);

        $migrationGenerator = new ModuleMigrationGenerator($this->commandData);
        $migrationGenerator->generate();

        $modelGenerator = new ModuleModelGenerator($this->commandData);
        $modelGenerator->generate();

        $requestGenerator = new ModuleRequestGenerator($this->commandData);
        $requestGenerator->generate();

        if($followRepoPattern)
        {
            $repositoryGenerator = new ModuleRepositoryGenerator($this->commandData);
            $repositoryGenerator->generate();

            $repoControllerGenerator = new ModuleRepoViewControllerGenerator($this->commandData);
            $repoControllerGenerator->generate();
        }
        else
        {
            $controllerGenerator = new ModuleViewControllerGenerator($this->commandData);
            $controllerGenerator->generate();
        }

        $viewsGenerator = new ModuleViewGenerator($this->commandData);
        $viewsGenerator->generate();

        $routeGenerator = new ModuleRoutesGenerator($this->commandData);
        $routeGenerator->generate();

        if($this->confirm("\nDo you want to migrate database? [y|N]", false)) {
            $particular =  Config::get('generator.tmp_modules', 'app/Modules/').ucfirst($this->commandData->moduleName).'/';
            $path = $particular.Config::get('generator.path_migration_module', app_path('Database/Migrations/'));
            // si no existe la tabla $this->commandData->moduleName
                $this->call('migrate', ['--path' => $path]);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        // dd("arg");
        return [
            ['module', InputArgument::REQUIRED, 'Singular Module name'],
            ['model', InputArgument::REQUIRED, 'Singular Model name']
        ];
    }
}