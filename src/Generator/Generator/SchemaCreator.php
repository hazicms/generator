<?php namespace HaziCms\Generator\Generator;


use Config;

class SchemaCreator
{
	public static function createField($field)
	{
		// params allowed on migrations
		$allowedParams = ['size'];

		$fieldType = self::map($field['fieldType']);

		if($field['fieldType'] == 'select' AND substr($field['fieldName'], -3) == '_id') {
			$fieldType = 'integer';
		}

		$fieldStr = "\t\t\t\$table->" . $fieldType . "('" . $field['fieldName'] . "'";

		if(!empty($field['fieldTypeParams']))
		{
			if($field['fieldValues'] != null) {
				$fieldStr .= ", ['".implode("', '", array_keys($field['fieldValues']))."']";
			} else {
				foreach($field['fieldTypeParams'] as $key => $param)
				{
					if(in_array($key, $allowedParams))  $fieldStr .= ", " . $param;
				}
			}
		}

		$fieldStr .= ")";

		if(!empty($field['fieldOptions']))
		{
			foreach($field['fieldOptions'] as $option)
			{
				if($option == 'primary')
					$fieldStr .= "->primary()";
				elseif($option == 'unique')
					$fieldStr .= "->unique()";
				else
					$fieldStr .= "->" . $option;
			}
		}

		if(!empty($fieldStr))
			$fieldStr .= ";\n";

		return $fieldStr;
	}

	public static function map($fieldType)
    {
    	$array = Config::get('generator.field_map');

        if (!array_key_exists($fieldType, $array)) return $fieldType;

        return $array[$fieldType];
    }
}