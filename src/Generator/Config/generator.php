<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Config for HaziCms\Generator
	|--------------------------------------------------------------------------
	|
	| Basic configuration for HaziCms\Generator
	|
	*/

	// Namespace for HaziCms\Generator's generated files.
	'namespace' => 'HaziCms',
	// Column that are going to appear on index view.
	'allowedColumns' => ['title', 'group'],

    /*
	|--------------------------------------------------------------------------
	| Path for modules
	|--------------------------------------------------------------------------
	|
	| All modules will be created on these relevant path
	|
	*/

    'tmp_modules' => 'app/Modules/',

    'path_migration_module' => 'Database/Migrations/',

    'path_model_module' => 'Entities/',

    'path_repository_module' => 'Entities/',

    'path_controller_module' => 'Http/Controllers/',

    'path_api_controller_module' => 'Http/Controllers/API/',

    'path_views_module' => 'Resources/views/',

    'path_request_module' => 'Http/Requests/',

    'path_routes_module' => 'Http/routes.php',

    /*
    |--------------------------------------------------------------------------
    | Namespace for modules
    |--------------------------------------------------------------------------
    |
    | All modules will be created with these namespaces
    |
    */

    'namespace_base' => 'Cms\Modules',

    'namespace_model_module' => 'Entities',

    'namespace_repository_module' => 'Entities',

    'namespace_controller_module' => 'Http\Controllers',

    'namespace_api_controller_module' => 'Http\Controllers\API',

    'namespace_request_module' => 'Http\Requests',

    /*
    |--------------------------------------------------------------------------
    | Path for classes
    |--------------------------------------------------------------------------
    |
    | All Classes will be created on these relevant path
    |
    */

	'path_migration' => base_path('database/migrations/'),

	'path_model' => app_path('Models/'),

	'path_repository' => app_path('Libraries/Repositories/'),

	'path_controller' => app_path('Http/Controllers/'),

	'path_api_controller' => app_path('Http/Controllers/API/'),

	'path_views' => base_path('resources/views'),

	'path_request' => app_path('Http/Requests/'),

	'path_routes' => app_path('Http/routes.php'),

	/*
	|--------------------------------------------------------------------------
	| Config for fields
	|--------------------------------------------------------------------------
	|
	*/

	'field_map' => [
		'textarea' => 'text',
    	'text' => 'string',
    	'select' => 'enum',
    	'radio' => 'text',
    	'check' => 'text',
    	'number' => 'integer',
    	'date' => 'datetime'
    ],

    'view_map' => [
    	'float' => 'double'
    ],
	
	/*
	|--------------------------------------------------------------------------
	| Namespace for classes
	|--------------------------------------------------------------------------
	|
	| All Classes will be created with these namespaces
	|
	*/

	'namespace_model' => 'App\Entities',

	'namespace_repository' => 'App\Libraries\Repositories',

	'namespace_controller' => 'App\Http\Controllers',

	'namespace_api_controller' => 'App\Http\Controllers\API',

	'namespace_request' => 'App\Http\Requests',

	/*
	|--------------------------------------------------------------------------
	| Model extend
	|--------------------------------------------------------------------------
	|
	| Model extend Configuration.
	| By default Eloquent model will be used.
	| If you want to extend your own custom model then you can specify "model_extend" => true and "model_extend_namespace" & "model_extend_class".
	|
	| e.g.
	| 'model_extend' => true,
	| 'model_extend_namespace' => 'App\Models\AppBaseModel as AppBaseModel',
	| 'model_extend_class' => 'AppBaseModel',
	|
	*/

	'model_extend' => true,

	'model_extend_namespace' => 'Illuminate\Database\Eloquent\Model',

	'model_extend_class' => 'Model',

	/*
	|--------------------------------------------------------------------------
	| API routes prefix
	|--------------------------------------------------------------------------
	|
	| By default "api" will be prefix
	|
	*/

	'api_prefix'	=>   'api',
];
