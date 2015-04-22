<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

interface Field {
	/**
	 * Define the response Html for field.
	 *
	 * @param $name string
	 * @param $value array
	 * @param $default integer/string
	 * @param $attr array
	 * 
	 * @return Response
	 */
	public function getHtml($name, array $value, $default, array $attr);
}