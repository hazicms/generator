<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;

class ModuleViewControllerGenerator implements GeneratorProvider
{
    /** @var  CommandData */
    private $commandData;

    private $path;

    private $namespace;

    private $requestNamespace;

    function __construct($commandData)
    {
        $this->commandData = $commandData;
        // $this->path = Config::get('generator.path_controller', app_path('Http/Controllers/'));
        $particular =  base_path(Config::get('generator.tmp_modules', 'app/Modules/')).ucfirst($commandData->moduleName).'/';
        $this->path = $particular.Config::get('generator.path_controller_module', app_path('Http/Controllers/')).'/'.$this->commandData->modelName . '/' ;

        // $this->namespace = Config::get('generator.namespace_controller', 'App\Http\Controllers');
        // $this->requestNamespace = Config::get('generator.namespace_request', 'App\Http\Requests');
        $particular = Config::get('generator.namespace_base', 'App').'\\'.ucfirst($commandData->moduleName).'\\';
        $this->namespace = $particular.Config::get('generator.namespace_controller_module', 'App\Http\Controllers');
        $this->requestNamespace = $particular.Config::get('generator.namespace_request_module', 'App\Http\Requests');
    }

    public function generate()
    {
        $templateData = $this->commandData->templatesHelper->getTemplate("Controller", "Scaffold");

        $templateData = $this->fillTemplate($templateData);

        $fileName = $this->commandData->modelName . "Controller.php";

        $path = $this->path . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->comment("\nController created: ");
        $this->commandData->commandObj->info($fileName);
    }

    private function fillTemplate($templateData)
    {
        $templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
        $templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);

        $templateData = str_replace('$REQUEST_NAMESPACE$', $this->requestNamespace, $templateData);

        $templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
        $templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

        $templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);
        $templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);

        return $templateData;
    }
}