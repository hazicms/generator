<?php namespace HaziCms\Generator\Generator\Generators\Module;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use HaziCms\Generator\Generator\Templates\TemplatesHelper;

class ModuleModelGenerator implements GeneratorProvider
{
    private $commandData;

    private $path;

    private $namespace;

    private $customModelExtend;

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
        $this->path = $particular.Config::get('generator.path_model_module', app_path('/'));

        $particular = Config::get('generator.namespace_base', 'App').'\\'.ucfirst($commandData->moduleName).'\\';
        $this->namespace = $particular.Config::get('generator.namespace_model_module', 'App');

        $this->customModelExtend = Config::get('generator.model_extend', false);

        $this->viewsPath = "Module";

        $namespaceBase = Config::get('generator.namespace', 'App');
        $this->modelRelations = "public function user() {
            return \$this->belongsTo('".$namespaceBase."\User');
        }";
    }

    /**
     * Generate a new module migration file.
     *
     * @return null
     * 
     */
    function generate()
    {
        $templateName = "Model";

        if($this->customModelExtend)
        {
            $templateName = "Model_Extended";
        }

        // $templateData = $this->commandData->templatesHelper->getTemplate($templateName, "Common");
        $moduleTemplate = new TemplatesHelper();
        $templateData = $moduleTemplate->getTemplate($templateName, $this->viewsPath);

        $templateData = $this->fillTemplate($templateData);

        $fileName = $this->commandData->modelName . ".php";

        if(!file_exists($this->path))
            mkdir($this->path, 0755, true);

        $path = $this->path . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->comment("\nModel created: ");
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
        $templateData = str_replace('$MODEL_RELATIONS$', $this->modelRelations, $templateData);

        $templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);

        $templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);

        $templateData = str_replace('$TABLE_NAME$', $this->commandData->tableName, $templateData);

        if($this->customModelExtend)
        {
            $templateData = str_replace(
                '$MODEL_EXTEND_NAMESPACE$',
                Config::get('generator.model_extend_namespace', 'Illuminate\Database\Eloquent\Model'),
                $templateData
            );

            $templateData = str_replace(
                '$MODEL_EXTEND_CLASS$',
                Config::get('generator.model_extend_class', 'Model'),
                $templateData
            );
        }

        $fillables = [];

        foreach($this->commandData->inputFields as $field)
        {
            $fillables[] = '"' . $field['fieldName'] . '"';
        }

        $templateData = str_replace('$FIELDS$', implode(",\n\t\t", $fillables), $templateData);

        $templateData = str_replace('$RULES$', implode(",\n\t\t", $this->generateRules()), $templateData);

        return $templateData;
    }

    /**
     * Generate rules.
     *
     * @return string
     * 
     */
    private function generateRules()
    {
        $rules = [];

        foreach($this->commandData->inputFields as $field)
        {
            if(!empty($field['validations']))
            {
                $rule = '"' . $field['fieldName'] . '" => "' . $field['validations'] . '"';
                $rules[] = $rule;
            }
        }

        return $rules;
    }


}