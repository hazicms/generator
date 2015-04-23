<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\Field;
use Form;

class SchemaBuilderFloatField implements Field {

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
	public function getHtml($name, $value = null, $default = null, array $attr = null) {
		// return Form::number('a');
		return Form::input('number', $name, $value, $attr);
	}
}