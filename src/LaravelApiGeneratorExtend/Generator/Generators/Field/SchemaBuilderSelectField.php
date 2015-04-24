<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

class SchemaBuilderSelectField extends FieldHelper implements Field {

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
		$format = "Form::select('%s', %s, %s, %s)";
		return sprintf($format, $name, FieldHelper::arrayToString($value), "$".$default, FieldHelper::arrayToString($attr));
	}
}