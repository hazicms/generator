<?php namespace HaziCms\Generator\Generator\Generators\Module;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use HaziCms\Generator\Generator\TemplatesHelper;

class ModuleRoutesGenerator implements GeneratorProvider
{
    private $commandData;

    private $path;

    private $apiPrefix;

    private $apiNamespace;

    /**
     * Create a new modulemigrationgenerator instance.
     *
     * @param $commandData Mitul\Generator\CommandData
     * 
     */
    function __construct($commandData)
    {
        $this->commandData = $commandData;

        $particular =  base_path(Config::get('generator.tmp_modules', 'app/Modules/')).ucfirst($commandData->moduleName).'/';
        $this->path = $particular.Config::get('generator.path_routes_module', app_path('Http/routes.php'));

        $this->apiPrefix = Config::get('generator.api_prefix', 'api');
        $this->apiNamespace = Config::get('generator.namespace_api_controller', 'App\Http\Controllers\API');
    }

    /**
     * Generate a new module migration file.
     *
     * @return null
     * 
     */
    public function generate()
    {
        $routeContents = $this->commandData->fileHelper->getFileContents($this->path);

        if($this->commandData->commandType == CommandData::$COMMAND_TYPE_API)
        {
            $routeContents .= $this->generateAPIRoutes();
        }
        else if($this->commandData->commandType == CommandData::$COMMAND_TYPE_SCAFFOLD)
        {
            $routeContents .= $this->generateScaffoldRoutes();
        }
        else if($this->commandData->commandType == CommandData::$COMMAND_TYPE_SCAFFOLD_API)
        {
            $routeContents .= $this->generateAPIRoutes();
            $routeContents .= $this->generateScaffoldRoutes();
        }

        $this->commandData->fileHelper->writeFile($this->path, $routeContents);
        $this->commandData->commandObj->comment("\nroutes.php modified:");
        $this->commandData->commandObj->info("\"" . $this->commandData->modelNamePluralCamel . "\" route added.");
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
        $templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
        $templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);
        $templateData = str_replace('$NAMESPACE_BASE$', $this->commandData->base, $templateData);

        return $templateData;
    }

    /**
     * Generate API routes.
     *
     * @return string
     * 
     */
    private function generateAPIRoutes()
    {
        $apiNamespacePostfix = substr($this->apiNamespace, strlen('App\Http\Controllers\\'));

        return "\n\nRoute::resource('" . $this->apiPrefix . "/" . $this->commandData->modelNamePluralCamel . "', '" . $apiNamespacePostfix . "\\" . $this->commandData->modelName . "APIController');";
    }

    /**
     * Generate Scaffold routes.
     *
     * @return string
     * 
     */
    private function generateScaffoldRoutes()
    {
        $namespace = Config::get('generator.namespace_base', base_path('resources/views'));
        $module = $this->commandData->moduleName;
        $controller = Config::get('generator.namespace_controller_module', base_path('resources/views'));
        $this->commandData->base = $namespace.'\\'.$module.'\\'.$controller.'\\'.$this->commandData->modelName."Controller";

        $routes = "\n\nRoute::resource('admin/" . $this->commandData->modelNamePluralCamel . "', '".$this->commandData->base."');";
        $routes .= "\n\nRoute::get('" . $this->commandData->modelNamePluralCamel . "/{id}', [\n'as' => '" . $this->commandData->modelNamePluralCamel . ".show',\n'uses' => '".$this->commandData->base."@show'\n]);";

        return $routes;
    }

}
