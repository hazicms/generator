<?php namespace HaziCms\Generator\Generator\Templates;


class TemplatesHelper
{
	public function getTemplate($template, $type = "Common")
	{
		// $path = base_path('vendor/mitulgolakiya/laravel-api-generator/src/Mitul/Generator/Templates/' . $type . '/' . $template . '.txt');
		$path = base_path('vendor/hazicms/generator/src/Generator/Generator/Templates/' . $type . '/' . $template . '.txt');

		$fileData = file_get_contents($path);

		return $fileData;
	}

}