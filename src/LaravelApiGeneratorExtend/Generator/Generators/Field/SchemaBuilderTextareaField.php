<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\Field;

class SchemaBuilderTextareaField extends FieldHelper implements Field {

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
		$attr['class'] = "ckeditor";
		$format = "{!! Form::textarea('%s', null, %s) !!}";
		return sprintf($format, $name, FieldHelper::arrayToString($attr));
	}

}