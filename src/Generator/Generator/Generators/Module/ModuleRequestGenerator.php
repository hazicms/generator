<?php namespace HaziCms\Generator\Generator\Generators\Module;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use HaziCms\Generator\Generator\TemplatesHelper;

class ModuleRequestGenerator implements GeneratorProvider
{
    private $commandData;

    private $path;

    private $namespace;

    /**
     * Create a new modulemigrationgenerator instance.
     *
     * @param $commandData Mitul\Generator\CommandData
     * 
     */
    function __construct($commandData)
    {
        $this->commandData = $commandData;

        $this->namespace = Config::get('generator.namespace', 'App');

        $particular =  base_path(Config::get('generator.tmp_modules', 'app/Modules/')).ucfirst($commandData->moduleName).'/';
        $this->path = $particular.Config::get('generator.path_request_module', app_path('Http/Requests/'));

        $particular = Config::get('generator.namespace_base', 'App').'\\'.ucfirst($commandData->moduleName).'\\';
        $this->moduleNamespace = $particular.Config::get('generator.namespace_request_module', 'App\Http\Requests');

        $this->commandData->modelNamespace = Config::get('generator.namespace_base', 'App') . "\\" . $commandData->moduleName . "\\" .Config::get('generator.namespace_model_module', 'App'). "\\" . $commandData->modelName ;

    }

    /**
     * Generate a new module migration file.
     *
     * @return null
     * 
     */
    function generate()
    {
        $moduleTemplate = new TemplatesHelper();
        $templateData = $moduleTemplate->getTemplate("Request", "Module");

        $templateData = $this->fillTemplate($templateData);

        $fileName = "Create" . $this->commandData->modelName . "Request.php";

        $path = $this->path . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->comment("\nRequest created: ");
        $this->commandData->commandObj->info($fileName);
    }

    /**
     * Fill template.
     *
     * @param $templateData string
     *
     * @return string
     */
    private function fillTemplate($templateData)
    {
        $templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);

        $templateData = str_replace('$MODULE_NAMESPACE$', $this->moduleNamespace, $templateData);
      
        $templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);
      
        $templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);

        return $templateData;
    }
}