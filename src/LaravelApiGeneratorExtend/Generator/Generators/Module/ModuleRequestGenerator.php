<?php namespace HaziCms\Generator\Generator\Generators\Module;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use HaziCms\Generator\Generator\Templates\TemplatesHelper;

class ModuleRequestGenerator implements GeneratorProvider
{
    /** @var  CommandData */
    private $commandData;

    private $path;

    private $namespace;

    function __construct($commandData)
    {
        $this->commandData = $commandData;

        // $this->path = Config::get('generator.path_request', app_path('Http/Requests/'));
        $particular =  base_path(Config::get('generator.tmp_modules', 'app/Modules/')).ucfirst($commandData->moduleName).'/';
        $this->path = $particular.Config::get('generator.path_request_module', app_path('Http/Requests/'));

        // $this->namespace = Config::get('generator.namespace_request', 'App\Http\Requests');
        $particular = Config::get('generator.namespace_base', 'App').'\\'.ucfirst($commandData->moduleName).'\\';
        $this->namespace = $particular.Config::get('generator.namespace_request_module', 'App\Http\Requests');

        // $this->commandData->modelNamespace = 'Cms\Modules\Modulo\Entities\Modelo';
        $this->commandData->modelNamespace = Config::get('generator.namespace_base', 'App') . "\\" . $commandData->moduleName . "\\" .Config::get('generator.namespace_model_module', 'App'). "\\" . $commandData->modelName ;

    }

    function generate()
    {
        // $templateData = $this->commandData->templatesHelper->getTemplate("Request", "Scaffold");
        $moduleTemplate = new TemplatesHelper();
        $templateData = $moduleTemplate->getTemplate("Request", "Module");

        $templateData = $this->fillTemplate($templateData);

        $fileName = "Create" . $this->commandData->modelName . "Request.php";

        $path = $this->path . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->comment("\nRequest created: ");
        $this->commandData->commandObj->info($fileName);
    }

    private function fillTemplate($templateData)
    {
        $templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
      
        $templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);
      
        $templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);

        return $templateData;
    }
}