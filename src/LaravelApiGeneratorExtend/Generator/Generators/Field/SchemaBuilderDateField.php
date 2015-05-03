<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field;

use Aitiba\LaravelApiGeneratorExtend\Generator\Generators\Field\Field;

class SchemaBuilderDateField extends FieldHelper implements Field {

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
		$attr['class'] = "date";
		$format = "@section('css')
			<link href='/theme/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css' rel='stylesheet' type='text/css' />
		@stop

		@section('js')
    		<script src='/theme/bootstrap-datepicker/dist/js/bootstrap-datepicker.js'></script>
    		<script src='/theme/bootstrap-datepicker/dist/locales/bootstrap-datepicker.eu.min.js'></script>
    		<script>
	         	$(document).ready(function() {
    	        	$('.date').datepicker({
        	    	format: 'yyyy-mm-dd 00:00:00',
				    weekStart: 1,
			    	language: 'eu',
			    	autoclose: true,
			    	todayHighlight: true
				});
			});
    		</script>
		@stop
		{!! Form::text('%s', null, %s) !!}";

		return sprintf($format, $name, FieldHelper::arrayToString($attr));
	}

}