<?php 
namespace HaziCms\Generator\Generator\Generators\Field;

abstract class FieldHelper
{
	/**
	 * Convert array on string.
	 *
	 * @param $attr array
	 * 
	 * @return string
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