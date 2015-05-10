<?php namespace HaziCms\Generator\Generator\Generators\Field;

use HaziCms\Generator\Generator\Generators\Field\Field;

class SchemaBuilderNumberField extends FieldHelper implements Field {

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
		$format = "{!! Form::number('%s', %s, %s) !!}";
		
		return sprintf($format, $name, $value, FieldHelper::arrayToString($attr));
	}

}