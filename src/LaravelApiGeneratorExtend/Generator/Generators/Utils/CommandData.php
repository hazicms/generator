<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Utils;


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

	/** @var  string */
	public $commandType;

	/** @var  APIGeneratorCommand */
	public $commandObj;

	/** @var FileHelper */
	public $fileHelper;

	/** @var TemplatesHelper */
	public $templatesHelper;

	/** @var  bool */
	public $useSoftDelete;

	public static $COMMAND_TYPE_API = 'api';
	public static $COMMAND_TYPE_SCAFFOLD = 'scaffold';
	public static $COMMAND_TYPE_SCAFFOLD_API = 'scaffold_api';

	function __construct($commandObj, $commandType)
	{
		$this->commandObj = $commandObj;
		$this->commandType = $commandType;
		$this->fileHelper = new FileHelper();
		$this->templatesHelper = new TemplatesHelper();
	}

	public function initVariables()
	{
		$this->modelNamePlural = Str::plural($this->modelName);
		$this->tableName = strtolower(Str::snake($this->modelNamePlural));
		$this->modelNameCamel = Str::camel($this->modelName);
		$this->modelNamePluralCamel = Str::camel($this->modelNamePlural);
		$this->modelNamespace = Config::get('generator.namespace_model_module', 'App') . "\\" . $this->modelName;
	}

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
// var_dump($fieldInputs);
			if(sizeof($fieldInputs) < 2 OR sizeof($fieldInputs) > 4)
			{
				$this->commandObj->error("Invalid Input. Try again");
				continue;
			}

			$fieldName = $fieldInputs[0];
			$fieldTypeOptions = explode(",", $fieldInputs[1]);
			$fieldType = $fieldTypeOptions[0];
			$fieldTypeParams = [];
			// if(sizeof($fieldTypeOptions) == 1)
			// {
			for($i = 1; $i < sizeof($fieldTypeOptions); $i++) {
				// dd($fieldTypeOptions);
				if (strpos($fieldTypeOptions[$i],"=>") !== false) {
					$option = explode("=>", $fieldTypeOptions[$i]);
					$option = $this->sanitizeArrayCommandData($option);
					// $option[0] = trim(rtrim($option[0],"'"),"'");
					// $option[1] = trim(rtrim($option[1]));
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
				//dd($fieldTypeParams);
			// }

// 			$fieldOptions = [];
// 			if(sizeof($fieldInputs) > 2) {
// 				$fieldOptions[] = $fieldInputs[2];				
// 			}
// dd($fieldOptions);
			$fieldValues = null;
			if (isset($fieldInputs[2])) {
				$fieldInputs[2] = $this->sanitizeArrayExplode($fieldInputs[2]);
				// dd($fieldInputs[2]);
				// foreach ($fieldInputs[2] as $key => $value) {
				// 	var_dump($value);
				// }
				// dd("a");
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
				// 'fieldOptions'    => $fieldOptions,
				'fieldValues'	  => $fieldValues,
				'fieldDefault'	  => $fieldDefault,
				'validations'     => $validations
			];

			$fields[] = $field;
			// dd($fields);
		}

		return $fields;
	}

	private function sanitizeArrayExplode($inputs)
	{
			$inputs = substr($inputs, 1);
			// dd($string);
			$inputs = substr($inputs, 1, strlen($inputs)-3);
		$inputs = explode(",", $inputs);

		for($i = 1; $i < sizeof($inputs); $i++) {
			// echo $inputs[$i];
			// $inputs[$i] = trim($inputs[$i]);
			// $inputs[$i] = rtrim($inputs[$i], "[");
			// $inputs[$i] = str_replace($inputs[$i], "", "[");
			// $inputs[$i] = str_replace($inputs[$i], "", "']");
			// $inputs[$i] = trim($inputs[$i], "']");
			
			// dd($inputs);
			//$input = explode(",", $inputs);
			$res = [];
			foreach ($inputs as $x => $input) {
				$in = explode("=>", $input);
				$in[0] = trim($in[0]);
				$in[0] = trim($in[0], "'");
				$in[1] = trim($in[1]);
				$in[1] = trim($in[1], "'");

				// $strr = $strr[$x];
				//var_dump($in);
				$res[$in[0]] = $in[$x];
			}
			// dd($res);
		}
		return $res;
	}

	private function sanitizeArrayCommandData($option) 
	{
		//array_walk
	
		$option[0] = trim($option[0]);
		$option[0] = trim($option[0],"'");
		$option[0] = rtrim($option[0],"'");
		
		$option[1] = trim($option[1]);
		$option[1] = trim($option[1],"'");
		$option[1] = rtrim($option[1],"'");

		return $option;
	}
}