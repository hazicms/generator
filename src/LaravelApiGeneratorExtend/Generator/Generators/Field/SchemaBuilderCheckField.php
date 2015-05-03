<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

use Mitul\Generator\CommandData;

class SchemaBuilderCheckField extends FieldHelper implements Field {

	public function __construct($commandData) 
	{
		$this->commandData = $commandData;
	}

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
		$format = "";

		foreach($value as $v) {

			$format .= "{!! Form::label('".$v."[]', '".ucfirst($v)."') !!}
			{!! Form::checkbox('".$name."', '".$v."') !!}";
		}
				
		return $format;

	}
}