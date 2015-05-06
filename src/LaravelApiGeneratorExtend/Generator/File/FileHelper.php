<?php namespace HaziCms\Generator\Generator\File;

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
        // $path = '/var/www/myblog/app/Modules/'.ucfirst($name);
        $path = app_path('Modules/').ucfirst($name);
        if(!File::exists($path)) {
            return false;
            // File::makeDirectory($path, 0777, true, true);
        }
        return true;
    }

    /**
     * Call to make the module on pingpong/modules package
     *
     * @param $name
     * @return bool
     */
    public function makeModuleStructure($name)
    {
        Artisan::call('module:make', ['name' => [$name]]);
        $this->deleteRoutesGarbage($name);
    }

    /**
     * Fixing function to delete the pingpong/modules package
     * inherited routes (ñapa)
     * 
     * @param $name
     * @return bool
     */
    private function deleteRoutesGarbage($name)
    {
        File::put(app_path('Modules/').ucfirst($name).'/Http/routes.php', '<?php ');
    }
}