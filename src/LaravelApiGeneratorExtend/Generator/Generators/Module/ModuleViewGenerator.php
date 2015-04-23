<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Module;

use Config;
use Illuminate\Support\Str;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use Aitiba\LaravelApiGeneratorExtend\Generator\Templates\TemplatesHelper;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\SchemaBuilderSelectField;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\SchemaBuilderFloatField;
use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\SchemaBuilderTextField;

class ModuleViewGenerator implements GeneratorProvider
{
    /** @var  CommandData */
    private $commandData;

    private $path;

    private $viewsPath;

    private $repoNamespace;

    function __construct($commandData)
    {
        $this->commandData = $commandData;
        // $this->path = Config::get('generator.path_views', base_path('resources/views')) . '/' . $this->commandData->modelNamePluralCamel . '/';
        $particular =  base_path(Config::get('generator.tmp_modules', 'app/Modules/')).ucfirst($commandData->moduleName).'/';
        $this->path = $particular.Config::get('generator.path_views_module',base_path('resources/views')).'/'.$this->commandData->modelName . '/' ;
        $this->repoNamespace = $particular.Config::get('generator.namespace_repository_module', 'App\Libraries\Repositories');
        $this->viewsPath = "Module/Views";
    }

    public function generate()
    {
        if(!file_exists($this->path))
            mkdir($this->path, 0755, true);
        if(!file_exists($this->path . 'public/'))
            mkdir($this->path . 'public/', 0755, true);
        if(!file_exists($this->path . 'admin/'))
            mkdir($this->path . 'admin/', 0755, true);

        $this->commandData->commandObj->comment("\nViews created: ");
        $this->generateFields();
        $this->generateIndex();
        $this->generateShow();
        $this->generateCreate();
        $this->generateEdit();
    }

    private function generateFields()
    {
        // $fieldTemplate = $this->commandData->templatesHelper->getTemplate("field.blade", $this->viewsPath);
        $moduleTemplate = new TemplatesHelper();
        $fieldTemplate = $moduleTemplate->getTemplate("field.blade", $this->viewsPath);

        $fieldsStr = "";


        foreach($this->commandData->inputFields as $field)
        {
            $fieldType = $this->generateField($field['fieldName'], $field['fieldType'], $field['fieldTypeParams'], $field['fieldValues'], $field['fieldDefault']);
            // $fieldType = $this->map($field['fieldType']);
            // dd($field);
            $singleFieldStr = str_replace('$FIELD_NAME_TITLE$', Str::title($field['fieldName']), $fieldTemplate);
            $singleFieldStr = str_replace('$FIELD_NAME$', $field['fieldName'], $singleFieldStr);
            $singleFieldStr = str_replace('$FIELD_TYPE$', $fieldType, $singleFieldStr);

            $fieldsStr .= $singleFieldStr . "\n\n";
        }

        // $templateData = $this->commandData->templatesHelper->getTemplate("fields.blade", $this->viewsPath);
        $templateData = $moduleTemplate->getTemplate("fields.blade", $this->viewsPath);

        $templateData = str_replace('$FIELDS$', $fieldsStr, $templateData);
        $templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);
        $templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);
        $templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);

        $fileName = "form.blade.php";

        $path = $this->path . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info("field.blade.php created");
    }

    private function map($fieldType)
    {
        $array = ['float' => 'number'];

        //TODO: move to generator.generator_views_map config
        if (!array_key_exists($fieldType, $array)) return $fieldType;

        return $array[$fieldType];
    }

    private function generateField($fieldName, $fieldType, $fieldTypeParams, $fieldValues, $fieldDefault)
    {
        // dd($fieldTypeParams);
        $fieldType = $this->map($fieldType);

        // dd($fieldType);
        switch ($fieldType) {
            //  group:select,'id' => 'mySelect', 'class' => 'red':['admin' => 'admin','user' => 'user']:user
            case 'select':
                $select = new SchemaBuilderSelectField;
                return $select->getHtml($fieldName, $fieldValues, $fieldDefault, $fieldTypeParams);
                break;
                // title:text,'size' => 255
            case 'text':
                $field = new SchemaBuilderTextField;
                return $field->getHtml($fieldName, $fieldValues, $fieldDefault, $fieldTypeParams);
                break;
            
            default:
                # code...
                break;
        }
        // $data = [
    //  'values' => [0 => 'admin', 1 => 'user'],
    //  'default' => 1,
    //  'attr'   => ['id' => 'mySelect', 'class' => 'red']
    // ];

    // $select = new SchemaBuilderSelectField;
    // echo ($select->getHtml('group', $data['values'], $data['default'],$data['attr']));
    //
    
    // $data = [
    //     'attr'   => ['step' => '0.1', 'min' => '1', 'max' => '5']
    // ];

    // $select = new SchemaBuilderFloatField;
    // echo ($select->getHtml('group', null, null,$data['attr']));
    }

    private function generateIndex()
    {
        // $templateData = $this->commandData->templatesHelper->getTemplate("index.blade", $this->viewsPath);
        $moduleTemplate = new TemplatesHelper();
        $templateData = $moduleTemplate->getTemplate("index.blade", $this->viewsPath);

        $templateData = $this->fillTemplate($templateData);

        $fileName = "index.blade.php";

        $headerFields = "";

        foreach($this->commandData->inputFields as $field)
        {
            $headerFields .= "<th>" . Str::title($field['fieldName']) . "</th>\n\t\t\t";
        }

        $headerFields = trim($headerFields);

        $templateData = str_replace('$FIELD_HEADERS$', $headerFields, $templateData);

        $tableBodyFields = "";

        foreach($this->commandData->inputFields as $field)
        {
            $tableBodyFields .= "<td>{!! $" . $this->commandData->modelNameCamel . "->" . $field['fieldName'] . " !!}</td>\n\t\t\t\t\t";
        }

        $tableBodyFields = trim($tableBodyFields);

        $templateData = str_replace('$FIELD_BODY$', $tableBodyFields, $templateData);

        $path = $this->path . 'admin/' . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info("index.blade.php created");
    }

    private function generateShow()
    {
        // $fieldTemplate = $this->commandData->templatesHelper->getTemplate("show.blade", $this->viewsPath);
        $moduleTemplate = new TemplatesHelper();
        $fieldTemplate = $moduleTemplate->getTemplate("show.blade", $this->viewsPath);

        $fileName = "show.blade.php";

        $path = $this->path . 'public/' . $fileName;

        $this->commandData->fileHelper->writeFile($path, $fieldTemplate);
        $this->commandData->commandObj->info("show.blade.php created");
    }

    private function generateCreate()
    {
        // $templateData = $this->commandData->templatesHelper->getTemplate("create.blade", $this->viewsPath);
        $moduleTemplate = new TemplatesHelper();
        $templateData = $moduleTemplate->getTemplate("create.blade", $this->viewsPath);

        $templateData = $this->fillTemplate($templateData);

        $fileName = "create.blade.php";

        $path = $this->path . 'admin/' . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info("create.blade.php created");
    }

    private function generateEdit()
    {
        // $templateData = $this->commandData->templatesHelper->getTemplate("edit.blade", $this->viewsPath);
        $moduleTemplate = new TemplatesHelper();
        $templateData = $moduleTemplate->getTemplate("edit.blade", $this->viewsPath);

        $templateData = $this->fillTemplate($templateData);

        $fileName = "edit.blade.php";

        $path = $this->path . 'admin/' . $fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info("edit.blade.php created");
    }

    private function fillTemplate($templateData)
    {
        $templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
        $templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

        $templateData = str_replace('$REPO_NAMESPACE$', $this->repoNamespace, $templateData);
        
        $templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);
        $templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);

        $templateData = str_replace('$MODULE_NAME$', strtolower($this->commandData->moduleName), $templateData);

        return $templateData;
    }
}