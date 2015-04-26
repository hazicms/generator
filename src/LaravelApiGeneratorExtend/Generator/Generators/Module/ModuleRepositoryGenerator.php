<?php

namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use Aitiba\LaravelApiGeneratorExtend\Generator\Templates\TemplatesHelper;

class ModuleRepositoryGenerator implements GeneratorProvider
{
    private $commandData;

    private $path;

    private $namespace;

    function __construct($commandData)
    {
        $this->commandData = $commandData;

        $particular =  base_path(Config::get('generator.tmp_modules', 'app/Modules/')).ucfirst($commandData->moduleName).'/';
        $this->path = $particular.Config::get('generator.path_repository_module', app_path('/'));
        $particular = Config::get('generator.namespace_base', 'App').'\\'.ucfirst($commandData->moduleName).'\\';
        $this->namespace = $particular.Config::get('generator.namespace_repository_module', 'App\Libraries\Repositories');
    }

    function generate()
    {
        $this->commandData->modelNamespace = $this->namespace . "\\" . $this->commandData->modelName;

        $moduleTemplate = new TemplatesHelper();
        $templateData = $moduleTemplate->getTemplate("Repository", "Module");
        //$templateData = $this->commandData->templatesHelper->getTemplate("Repository", "Common");

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