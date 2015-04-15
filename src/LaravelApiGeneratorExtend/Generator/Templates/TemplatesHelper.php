<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\Templates;


class TemplatesHelper
{
	public function getTemplate($template, $type = "Common")
	{
		// $path = base_path('vendor/mitulgolakiya/laravel-api-generator/src/Mitul/Generator/Templates/' . $type . '/' . $template . '.txt');
		$path = base_path('vendor/aitiba/laravelapigeneratorextend/src/LaravelApiGeneratorExtend/Generator/Templates/' . $type . '/' . $template . '.txt');

		$fileData = file_get_contents($path);

		return $fileData;
	}

	// public function getView($view, $type = "Common")
	// {
	// 	// $path = base_path('vendor/mitulgolakiya/laravel-api-generator/src/Mitul/Generator/Templates/' . $type . '/' . $template . '.txt');
	// 	$path = base_path('vendor/aitiba/laravelapigeneratorextend/src/LaravelApiGeneratorExtend/Generator/Templates/' . $type . '/Views/' . $view . '.txt');

	// 	$fileData = file_get_contents($path);

	// 	return $fileData;
	// }
}