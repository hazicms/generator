<?php namespace HaziCms\Generator\Generator\Commands;

use Illuminate\Console\Command;
use HaziCms\Generator\Generator\Generators\Utils\CommandData;
use HaziCms\Generator\Generator\Generators\Module\ModuleMigrationGenerator;
use HaziCms\Generator\Generator\Generators\Module\ModuleModelGenerator;
use HaziCms\Generator\Generator\Generators\Module\ModuleRepositoryGenerator;
use HaziCms\Generator\Generator\Generators\Module\ModuleRequestGenerator;
use HaziCms\Generator\Generator\Generators\Module\ModuleRoutesGenerator;
use HaziCms\Generator\Generator\Generators\Module\ModuleRepoViewControllerGenerator;
use HaziCms\Generator\Generator\Generators\Module\ModuleViewControllerGenerator;
use HaziCms\Generator\Generator\Generators\Module\ModuleViewGenerator;
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
    protected $name = 'hazicms:generator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a module for HaziCms';

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
        $fileHelper = new \HaziCms\Generator\Generator\File\FileHelper();
        // dd($fileHelper->moduleExists($name));
        if (! $fileHelper->moduleExists($this->commandData->moduleName)) {
            $fileHelper->makeModuleStructure($this->commandData->moduleName);
        } else {
            echo ('MODULE EXISTS... Great! Less work! :-)');
        }

        $this->getData();
    }

    /**
     * Ask needed data for generator.
     *
     * @return void
     */
    private function getData()
    {
        $this->commandData->initVariables();
        $this->commandData->inputFields = $this->commandData->getInputFields();

        $migrationGenerator = new ModuleMigrationGenerator($this->commandData);
        $migrationGenerator->generate();

        $modelGenerator = new ModuleModelGenerator($this->commandData);
        $modelGenerator->generate();

        $requestGenerator = new ModuleRequestGenerator($this->commandData);
        $requestGenerator->generate();

        $repositoryGenerator = new ModuleRepositoryGenerator($this->commandData);
        $repositoryGenerator->generate();
        
        $repoControllerGenerator = new ModuleRepoViewControllerGenerator($this->commandData);
        $repoControllerGenerator->generate();

        $viewsGenerator = new ModuleViewGenerator($this->commandData);
        $viewsGenerator->generate();

        $routeGenerator = new ModuleRoutesGenerator($this->commandData);
        $routeGenerator->generate();

        if($this->confirm("\nDo you want to migrate database? [y|N]", false)) {
            $particular =  Config::get('generator.tmp_modules', 'app/Modules/').ucfirst($this->commandData->moduleName).'/';
            $path = $particular.Config::get('generator.path_migration_module', app_path('Database/Migrations/'));
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
        return [
            ['module', InputArgument::REQUIRED, 'Singular Module name'],
            ['model', InputArgument::REQUIRED, 'Singular Model name']
        ];
    }
}