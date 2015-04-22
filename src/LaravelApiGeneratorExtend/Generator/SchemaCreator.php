<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator;

class SchemaCreator
{
	public static function createField($field)
	{
		$fieldType = self::map($field['fieldType']);

		$fieldStr = "\t\t\t\$table->" . $fieldType . "('" . $field['fieldName'] . "'";

		if(!empty($field['fieldTypeParams']))
		{
			foreach($field['fieldTypeParams'] as $param)
			{
				$fieldStr .= ", " . $param;
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
    	//TODO: move to generator.generator_fields_map config
    	$array = ['textarea' => 'text',
    			 'text' => 'string',
    			 'select' => 'enum'];

        if (!array_key_exists($fieldType, $array)) return $fieldType;

        return $array[$fieldType];
    }
}