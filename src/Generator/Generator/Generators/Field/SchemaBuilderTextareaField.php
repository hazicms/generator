<?php namespace HaziCms\Generator\Generator\Generators\Field;

use HaziCms\Generator\Generator\Generators\Field\Field;

class SchemaBuilderTextareaField extends FieldHelper implements Field {

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
	public function getHtml($name, $value = null, $default = null, array $attr = null) {
		$attr['class'] = "ckeditor";

		$format = "@section('js')
			<script src='/../theme/ckeditor/ckeditor.js'></script>
    		<script src='/../theme/ckeditor/config.js'></script>
    		<script src='/../theme/ckeditor/styles.js'></script>
		@stop
		{!! Form::textarea('%s', null, %s) !!}";
		
		return sprintf($format, $name, FieldHelper::arrayToString($attr));
	}

}