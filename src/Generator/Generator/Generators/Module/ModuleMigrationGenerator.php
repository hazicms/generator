<?php namespace HaziCms\Generator\Generator\Generators\Module;

use \Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use HaziCms\Generator\Generator\SchemaCreator;

class ModuleMigrationGenerator implements GeneratorProvider
{
    private $commandData;

    private $path;

    /**
     * Create a new modulemigrationgenerator instance.
     *
     * @param $commandData Mitul\Generator\CommandData
     * 
     */
    function __construct($commandData)
    {
        $this->commandData = $commandData;

        $particular = base_path(Config::get('generator.tmp_modules', 'app/Modules/')).ucfirst($commandData->moduleName).'/';
        $this->path = $particular.Config::get('generator.path_migration_module');

    }

    /**
     * Generate a new module migration file.
     *
     * @return null
     * 
     */
    public function generate()
    {
        $templateData = $this->commandData->templatesHelper->getTemplate("Migration", "Common");

        $templateData = $this->fillTemplate($templateData);

        $fileName = date('Y_m_d_His') . "_" . "create_" . $this->commandData->tableName . "_table.php";

        $path = $this->path . $fileName;
        
        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->comment("\nMigration created: ");
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
        $templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

        $templateData = str_replace('$TABLE_NAME$', $this->commandData->tableName, $templateData);

        $templateData = str_replace('$FIELDS$', $this->generateFieldsStr(), $templateData);

        return $templateData;
    }

    /**
     * Generate fields migration.
     *
     * @return string
     * 
     */
    private function generateFieldsStr()
    {
        $fieldsStr = "\$table->increments('id');\n";

        foreach($this->commandData->inputFields as $field)
        {
            $fieldsStr .= SchemaCreator::createField($field);
        }

        $fieldsStr .= "\t\t\t\$table->timestamps();\n";

        return $fieldsStr;
    }
}