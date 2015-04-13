<?php namespace Aitiba\LaravelApiGeneratorExtend\Generator\File;

use \File;
use \Artisan;

class FileHelper
{
	/**
     * Know if the module structure exists
     *
     * @param $name
     * @return bool
     */
    public function moduleExists($name)
    {
        $path = '/var/www/myblog/app/Modules/'.ucfirst($name);
        if(!File::exists($path)) {
            return false;
            // File::makeDirectory($path, 0777, true, true);
        }
        return true;
    }

    public function makeModuleStructure($name)
    {
        Artisan::call('module:make', ['name' => [$name]]);
        // Artisan::call('make:model', ['name' => 'test']);
    }
}