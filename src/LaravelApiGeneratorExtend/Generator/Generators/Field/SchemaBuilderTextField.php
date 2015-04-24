<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\Field;
use Form;

class SchemaBuilderTextField implements Field {

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
		// dd($attr);
		// $keys = array_keys($attr);
		// $values = array_values($attr);
		$attr['class'] = "form-control";
		// dd($attrStr);
		// $attrStr = "['".implode("', '", array_keys($attr))."']";
		// dd("Form::text(".$name.", null, ".$attrStr.")");
		return "Form::text('".$name."', null, ".$this->arrayToString($attr).")";
	}

	private function arrayToString($attr)
	{
		$attrStr = "[";
		foreach($attr as $key => $value) {
			$attrStr .= "'".$key."' => '".$value."',";
		}
		$attrStr = substr($attrStr, 0, -1);
		$attrStr .= "]";

		return $attrStr;
	}
}