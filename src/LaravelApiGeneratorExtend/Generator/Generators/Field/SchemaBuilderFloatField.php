<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\Field;

class SchemaBuilderFloatField extends FieldHelper implements Field {

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
	public function getHtml($name, $value = null, $default = null, array $attr = null) {
		// return "Form::input('number', '".$name."', '".$value."', ".FieldHelper::arrayToString($attr).")";
		
		$format = "{!! Form::number('%s', %s, %s) !!}";
		return sprintf($format, $name, $value, FieldHelper::arrayToString($attr));
	}

}