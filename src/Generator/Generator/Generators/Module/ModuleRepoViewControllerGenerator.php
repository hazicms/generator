<?php namespace HaziCms\Generator\Generator\Generators\Module;

use Config;
use Mitul\Generator\CommandData;
use HaziCms\Generator\Generator\Templates\TemplatesHelper;
use Mitul\Generator\Generators\GeneratorProvider;

class ModuleRepoViewControllerGenerator implements GeneratorProvider
{
    private $commandData;

    private $path;

    private $namespace;

    private $repoNamespace;

    private $requestNamespace;

     /**
     * Create a new modulemigrationgenerator instance.
     *
     * @param $commandData Mitul\Generator\CommandData
     * 
     */
    function __construct($commandData)
    {
        $this->commandData = $commandData;
// dd($this->commandData->inputFields);
        $this->namespace = Config::get('generator.namespace', 'App');

        $particular =  base_path(Config::get('generator.tmp_modules', 'app/Modules/')).ucfirst($commandData->moduleName).'/';
        $this->path = $particular.Config::get('generator.path_controller_module', app_path('Http/Requests/'));

        $particular = Config::get('generator.namespace_base', 'App').'\\'.ucfirst($commandData->moduleName).'\\';
        $this->moduleNamespace = $particular.Config::get('generator.namespace_controller_module', 'App\Http\Controllers');
        $this->repoNamespace = $particular.Config::get('generator.namespace_repository_module', 'App\Libraries\Repositories');
        $this->requestNamespace = $particular.Config::get('generator.namespace_request_module', 'App\Http\Requests');
    }

    /**
     * Generate a new module migration file.
     *
     * @return null
     * 
     */
    public function generate()
    {
        $moduleTemplate = new TemplatesHelper();

        $templateData = $moduleTemplate->getTemplate("ControllerRepo", "Module");
        $templateData = $this->fillTemplate($templateData);

        $fileName = $this->commandData->modelName . "Controller.php";

        $path = $this->path . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->comment("\nController created: ");
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
        $selectData = "";
        $selectViewData = "";

        foreach($this->commandData->inputFields as $field) {
            if($field['fieldType'] == "select") {
                if(substr($field['fieldName'], -3) == '_id') {
                    // echo "_id";
                    $name = explode("_", $field['fieldName']);
                    $entity = ucfirst($name[0]);
                    $selectData .= "\$".$name[0]."s = \HaziCms\Auth\\".$entity."::lists('name','id');\n\t\t";
                    $selectViewData .= "->with('".$name[0]."s', $".$name[0]."s";
                }
            }
        }

        if ($selectViewData != "") $selectViewData = ") ".$selectViewData;
        
        $templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
        
        $templateData = str_replace('$MODULE_NAMESPACE$', $this->moduleNamespace, $templateData);
        $templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);

        $templateData = str_replace('$REPO_NAMESPACE$', $this->repoNamespace, $templateData);
        $templateData = str_replace('$REQUEST_NAMESPACE$', $this->requestNamespace, $templateData);

        $templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
        $templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

        $templateData = str_replace('$MODULE_NAME$', strtolower($this->commandData->moduleName), $templateData);

        $templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);
        $templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);
        
        $templateData = str_replace('$SELECT_ID_CONTENT$', $selectData, $templateData);
        $templateData = str_replace('$SELECT_ID_VIEW$', $selectViewData, $templateData);
        
        return $templateData;
    }
}