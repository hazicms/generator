<?php namespace HaziCms\Generator\Generator\Generators\Field;

class SchemaBuilderHiddenField extends FieldHelper implements Field {

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
		// $attr['class'] = "form-control";
		$nameE = '';
		$format = "{!! Form::hidden('%s',  1) !!}";
		
		if(substr($name, -3) == '_id') {
			$nameE = explode("_", $name);
			$nameE = $nameE[0];
			$format = "{!! Form::hidden('%s',  Auth::%s()->id, %s) !!}";
		}
		// echo Form::hidden('email', 'example@gmail.com');
		
		return sprintf($format, $name, $nameE, FieldHelper::arrayToString($attr));
	}

}