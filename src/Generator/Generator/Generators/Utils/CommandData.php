<?php namespace HaziCms\Generator\Generator\Generators\Utils;


use \Config;
use Illuminate\Support\Str;
use Mitul\Generator\Commands\APIGeneratorCommand;
use Mitul\Generator\File\FileHelper;
use Mitul\Generator\Templates\TemplatesHelper;

class CommandData
{
	public $modelName;
	public $modelNamePlural;
	public $modelNameCamel;
	public $modelNamePluralCamel;
	public $modelNamespace;

	public $tableName;
	public $inputFields;

	public $commandType;

	public $commandObj;

	public $fileHelper;

	public $templatesHelper;

	public $useSoftDelete;

	public static $COMMAND_TYPE_API = 'api';
	public static $COMMAND_TYPE_SCAFFOLD = 'scaffold';
	public static $COMMAND_TYPE_SCAFFOLD_API = 'scaffold_api';

	/**
     * Create a new modulemigrationgenerator instance.
     *
     * @param $commandData Mitul\Generator\CommandData
     * 
     */
	function __construct($commandObj, $commandType)
	{
		$this->commandObj = $commandObj;
		$this->commandType = $commandType;
		$this->fileHelper = new FileHelper();
		$this->templatesHelper = new TemplatesHelper();
	}

	/**
     * Init variables needed for generator.
     *
     * @return null
     * 
     */
	public function initVariables()
	{
		$this->modelNamePlural = Str::plural($this->modelName);
		$this->tableName = strtolower(Str::snake($this->modelNamePlural));
		$this->modelNameCamel = Str::camel($this->modelName);
		$this->modelNamePluralCamel = Str::camel($this->modelNamePlural);
		$this->modelNamespace = Config::get('generator.namespace_model_module', 'App') . "\\" . $this->modelName;
	}

	/**
     * Command text for field ask.
     *
     * @return array
     * 
     */
	public function getInputFields()
	{
		$fields = [];

		$this->commandObj->info("Specify fields for the model (skip id & timestamp fields, will be added automatically)");
		$this->commandObj->info("Left blank to finish");

		while(true)
		{
			$fieldInputStr = $this->commandObj->ask("Field:");

			if(empty($fieldInputStr))
				break;

			$fieldInputs = explode(":", $fieldInputStr);

			if(sizeof($fieldInputs) < 2 OR sizeof($fieldInputs) > 4)
			{
				$this->commandObj->error("Invalid Input. Try again");
				continue;
			}

			$fieldName = $fieldInputs[0];
			$fieldTypeOptions = explode(",", $fieldInputs[1]);
			$fieldType = $fieldTypeOptions[0];
			$fieldTypeParams = [];

			for($i = 1; $i < sizeof($fieldTypeOptions); $i++) {
				if (strpos($fieldTypeOptions[$i],"=>") !== false) {
					$option = explode("=>", $fieldTypeOptions[$i]);
					$option = $this->sanitizeArrayCommandData($option);
					$fieldTypeParams[$option[0]] = $option[1];
				} else {
					$fieldTypeOptions = explode(",", $fieldInputs[1]);
					$fieldType = $fieldTypeOptions[0];
					$fieldTypeParams = [];
					if(sizeof($fieldTypeOptions) > 1)
					{
						for($i = 1; $i < sizeof($fieldTypeOptions); $i++)
							$fieldTypeParams[] = $fieldTypeOptions[$i];
					}
				}
			}

			$fieldValues = null;
			if (isset($fieldInputs[2])) {
				$fieldInputs[2] = $this->sanitizeArrayExplode($fieldInputs[2]);

				$fieldValues = $fieldInputs[2];
			}

			$fieldDefault = null;
			if(isset($fieldInputs[3]))
				$fieldDefault = $fieldInputs[3];

			$validations = $this->commandObj->ask("Enter validations: ");

			$field = [
				'fieldName'       => $fieldName,
				'fieldType'       => $fieldType,
				'fieldTypeParams' => $fieldTypeParams,
				'fieldValues'	  => $fieldValues,
				'fieldDefault'	  => $fieldDefault,
				'validations'     => $validations
			];

			$fields[] = $field;
		}

		return $fields;
	}

	/**
     * Sanitize array.
     *
     * @return array
     * 
     */
	private function sanitizeArrayExplode($inputs)
	{
		$inputs = substr($inputs, 1);		
		$inputs = substr($inputs, 1, strlen($inputs)-3);
		$inputs = explode(",", $inputs);	
			
		for($i = 1; $i < sizeof($inputs); $i++) {
			$res = [];
		
			foreach ($inputs as $x => $input) {
				$in = explode("=>", $input);
				$in[0] = ltrim($in[0], ' ');
				$in[0] = ltrim($in[0], '\'');
				$in[0] = rtrim($in[0], ' ');
				$in[0] = rtrim($in[0], '\'');

				$in[1] = ltrim($in[1], ' ');
				$in[1] = ltrim($in[1], '\'');
				$in[1] = rtrim($in[1], ' ');
				$in[1] = rtrim($in[1], '\'');

				$res[$in[0]] = $in[1];
			}
		}

		return $res;
	}

	/**
     * Sanitize array from command line.
     *
     * @return array
     * 
     */
	private function sanitizeArrayCommandData($option) 
	{
		$option[0] = trim($option[0]);
		$option[0] = trim($option[0],"'");
		$option[0] = rtrim($option[0],"'");
		
		$option[1] = trim($option[1]);
		$option[1] = trim($option[1],"'");
		$option[1] = rtrim($option[1],"'");

		return $option;
	}
}