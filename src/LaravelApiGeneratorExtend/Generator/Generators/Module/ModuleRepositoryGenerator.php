<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;

class ModuleRepositoryGenerator implements GeneratorProvider
{
    /** @var  CommandData */
    private $commandData;

    private $path;

    private $namespace;

    function __construct($commandData)
    {
        $this->commandData = $commandData;

        // $this->path = Config::get('generator.path_repository', app_path('/Libraries/Repositories/'));
        $particular =  base_path(Config::get('generator.tmp_modules', 'app/Modules/')).ucfirst($commandData->moduleName).'/';
        $this->path = $particular.Config::get('generator.path_repository_module', app_path('/'));

        // $this->namespace = Config::get('generator.namespace_repository', 'App\Libraries\Repositories');
        $particular = Config::get('generator.namespace_base', 'App').'\\'.ucfirst($commandData->moduleName).'\\';
        $this->namespace = $particular.Config::get('generator.namespace_repository_module', 'App\Libraries\Repositories');
        // dd($this->namespace);
    }

    function generate()
    {
        //  Cms\Modules\Modulo\Entities\Modelo
        $this->commandData->modelNamespace = $this->namespace . "\\" . $this->commandData->modelName;

        $templateData = $this->commandData->templatesHelper->getTemplate("Repository", "Common");

        $templateData = $this->fillTemplate($templateData);

        $fileName = $this->commandData->modelName . "Repository.php";

        if(!file_exists($this->path))
            mkdir($this->path, 0755, true);

        $path = $this->path . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->comment("\nRepository created: ");
        $this->commandData->commandObj->info($fileName);
    }

    private function fillTemplate($templateData)
    {
        $templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
        $templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);

        $templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
        $templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

        $templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);

        return $templateData;
    }

}