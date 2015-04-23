<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\Field;
use Form;

class SchemaBuilderSelectField implements Field {

	/**
	 * Define the response Html for field.
	 *
	 * @param $name string
	 * @param $value integer
	 * @param $default integer/string
	 * @param $attr array
	 * 
	 * @return Response
	 */
	public function getHtml($name, $value = null, $default, array $attr = null) {
		// return Form::select($name, $value, $default, $attr);
		// dd($value);
		// dd(Form::select($name, $value, $default, $attr));
		return Form::select($name, $value, $default, $attr);
	}
}