<?php namespace HaziCms\Generator\Generator\Generators\Field;

use Mitul\Generator\CommandData;

class SchemaBuilderSelectField extends FieldHelper implements Field {

	public function __construct($commandData) 
	{
		$this->commandData = $commandData;
	}
	/**
	 * Define the response Html for field.
	 *
	 * @param $name string
	 * @param $value integer
	 * @param $default integer/string
	 * @param $attr array
	 * 
	 * @return string
	 */
	public function getHtml($name, $value = null, $default, array $attr = null) {
		$format = "
			@if(isset(%s)) 
				{!! Form::select('%s', %s, %s, %s) !!} 
			@else 
				{!! Form::select('%s', %s, %s, %s) !!} 
			@endif";
		
		if (substr($name, -3) == '_id') {
			$nameE = explode("_", $name);
            $entity = $nameE[0];

			return sprintf($format, "\$status", $name, "$".$entity."s", "$".strtolower($this->commandData->modelName)."->".$name, FieldHelper::arrayToString($attr),
					    $name, "$".$entity."s", $default, FieldHelper::arrayToString($attr));
		} else {		
			return sprintf($format, "\$status", $name, FieldHelper::arrayToString($value), "$".strtolower($this->commandData->modelName)."->".$name, FieldHelper::arrayToString($attr),
					    $name, FieldHelper::arrayToString($value), $default, FieldHelper::arrayToString($attr));
		}
		

	}
}