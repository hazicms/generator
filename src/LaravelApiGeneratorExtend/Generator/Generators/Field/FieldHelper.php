<?php 
namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

abstract class FieldHelper
{
	/**
	 * Convert array on string.
	 *
	 * @param $atttr array
	 * 
	 * @return sting
	 */
	public static function arrayToString($attr)
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