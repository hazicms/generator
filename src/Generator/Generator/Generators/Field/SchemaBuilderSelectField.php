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
		// return "Form::select('".$name."', ".FieldHelper::arrayToString($value).", ".$default.", ".FieldHelper::arrayToString($attr).")";
		$format = "
				@if(isset(%s)) 
					{!! Form::select('%s', %s, %s, %s) !!} 
				@else 
					{!! Form::select('%s', %s, %s, %s) !!} 
				@endif";
				
		return sprintf($format, "\$status", $name, FieldHelper::arrayToString($value), "$".strtolower($this->commandData->modelName)."->".$name, FieldHelper::arrayToString($attr),
					    $name, FieldHelper::arrayToString($value), $default, FieldHelper::arrayToString($attr));

	}
}