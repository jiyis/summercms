<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout');
});


Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth.admin:admin'], function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

    //用户设置以及权限
    Route::resource('users', 'UserController');
    Route::post('users/destroyall', ['as' => 'users.destroy.all', 'uses' => 'UserController@destroyAll']);
    Route::resource('role', 'RoleController');
    Route::post('role/destroyall', ['as' => 'role.destroy.all', 'uses' => 'RoleController@destroyAll']);
    Route::get('role/{id}/permissions', ['as' => 'role.permissions', 'uses' => 'RoleController@permissions']);
    Route::post('role/{id}/permissions', ['as' => 'role.permissions', 'uses' => 'RoleController@storePermissions']);
    Route::resource('permission', 'PermissionController');
    Route::post('permission/destroyall', ['as' => 'permission.destroy.all', 'uses' => 'PermissionController@destroyAll']);
    //日志管理
    Route::get('operation/log',['as'=>'operationlog.index','uses'=>'LogController@operationLog']);
    Route::get('operation/ajax',['as'=>'operationlog.ajax','uses'=>'LogController@ajaxOperationLog']);
    Route::get('logs/index',['as'=>'logs.index','uses'=>'LogController@logs']);
    Route::get('logs/ajax',['as'=>'logs.ajax','uses'=>'LogController@ajaxLogs']);

    //发布管理
    Route::post('publish',['as'=>'publish','uses'=>'PublishController@publish']);


    //页面管理
    Route::resource('page', 'PageController');

    //布局管理
    Route::resource('layout', 'LayoutController');

    //模板管理
    Route::resource('template', 'TemplateController');

    //栏目管理
    Route::resource('category', 'CategoryController');


    // Main Admin and Logout Route
    Route::get('/', ['uses' => 'VoyagerController@index', 'as' => 'dashboard']);
    Route::post('upload', ['uses' => 'VoyagerController@upload', 'as' => 'upload']);

    Route::get('profile', [
        'as' => 'profile',
        function () {
            return view('voyager::profile');
        },
    ]);

    if (env('DB_CONNECTION') !== null && Schema::hasTable('data_types')):
        foreach (App\Models\DataType::all() as $dataTypes):
            Route::resource($dataTypes->slug, 'BreadController');
        endforeach;
    endif;

    // 菜单管理
    Route::get('menus/{id}/builder/', ['uses' => 'MenuController@builder', 'as' => 'menu.builder']);
    Route::delete('menu/delete_menu_item/{id}',
        ['uses' => 'MenuController@delete_menu', 'as' => 'menu.delete_menu_item']);
    Route::post('menu/add_item', ['uses' => 'MenuController@add_item', 'as' => 'menu.add_item']);
    Route::put('menu/update_menu_item',
        ['uses' => 'MenuController@update_item', 'as' => 'menu.update_menu_item']);
    Route::post('menu/order', ['uses' => 'MenuController@order_item', 'as' => 'menu.order_item']);

    // 系统设置管理
    Route::get('settings', ['uses' => 'SettingsController@index', 'as' => 'settings']);
    Route::post('settings', 'SettingsController@save');
    Route::post('settings/create', ['uses' => 'SettingsController@create', 'as' => 'settings.create']);
    Route::delete('settings/{id}', ['uses' => 'SettingsController@delete', 'as' => 'settings.delete']);
    Route::get('settings/move_up/{id}',
        ['uses' => 'SettingsController@move_up', 'as' => 'settings.move_up']);
    Route::get('settings/move_down/{id}',
        ['uses' => 'SettingsController@move_down', 'as' => 'settings.move_down']);
    Route::get('settings/delete_value/{id}',
        ['uses' => 'SettingsController@delete_value', 'as' => 'settings.delete_value']);

    // Admin Media
    /*Route::get('media', ['uses' => 'MediaController@index', 'as' => 'media']);
    Route::post('media/files', 'MediaController@files');
    Route::post('media/new_folder', 'MediaController@new_folder');
    Route::post('media/delete_file_folder', 'MediaController@delete_file_folder');
    Route::post('media/directories', 'MediaController@get_all_dirs');
    Route::post('media/move_file', 'MediaController@move_file');
    Route::post('media/rename_file', 'MediaController@rename_file');
    Route::post('media/upload', ['uses' => 'MediaController@upload', 'as' => 'media.upload']);*/

    // 数据库以及模型管理
    Route::get('database', ['uses' => 'DatabaseController@index', 'as' => 'database']);
    Route::get('database/create-table',
        ['uses' => 'DatabaseController@create', 'as' => 'database.create_table']);
    Route::post('database/create-table', 'DatabaseController@store');
    Route::get('database/table/{table}',
        ['uses' => 'DatabaseController@table', 'as' => 'database.browse_table']);
    Route::delete('database/table/delete/{table}', 'DatabaseController@delete');
    Route::get('database/edit-{table}-table',
        ['uses' => 'DatabaseController@edit', 'as' => 'database.edit_table']);
    Route::post('database/edit-{table}-table', 'DatabaseController@update');

    Route::post('database/create_bread',
        ['uses' => 'DatabaseController@addBread', 'as' => 'database.create_bread']);
    Route::post('database/store_bread',
        ['uses' => 'DatabaseController@storeBread', 'as' => 'database.store_bread']);
    Route::get('database/{id}/edit-bread',
        ['uses' => 'DatabaseController@addEditBread', 'as' => 'database.edit_bread']);
    Route::put('database/{id}/edit-bread', 'DatabaseController@updateBread')->name('bread.update');
    Route::delete('database/delete_bread/{id}',
        ['uses' => 'DatabaseController@deleteBread', 'as' => 'database.delete_bread']);
});
