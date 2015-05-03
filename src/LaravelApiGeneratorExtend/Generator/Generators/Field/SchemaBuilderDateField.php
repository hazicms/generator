<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\Field;

class SchemaBuilderDateField extends FieldHelper implements Field {

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
		$format = "{!! Form::text('%s', null, %s) !!}";
		return sprintf($format, $name, FieldHelper::arrayToString($attr));
	}

}