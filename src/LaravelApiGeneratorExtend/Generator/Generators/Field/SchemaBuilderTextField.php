<?php namespace HaziCms\Generator\Generator\Generators\Field;

class SchemaBuilderTextField extends FieldHelper implements Field {

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
		$attr['class'] = "form-control";
	
		// return "Form::text('".$name."', null, ".FieldHelper::arrayToString($attr).")";
		$format = "{!! Form::text('%s', null, %s) !!}";
		return sprintf($format, $name, FieldHelper::arrayToString($attr));
	}

}