<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



$api = app('Dingo\Api\Routing\Router');

$api->version('v1',['namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => ['cors']], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit'      => config('api.access.publish.limits'),
        'expires'    => config('api.access.publish.expires'),
    ], function($api) {
        $api->get('search','SearchController@search');
        $api->get('pages', 'PageController@index');

        if (env('DB_CONNECTION') !== null && Schema::hasTable('data_types')):
            foreach (App\Models\DataType::all() as $dataTypes):
                $api->get($dataTypes->slug, 'BreadController@index');
                $api->get($dataTypes->slug.'/{id}/visits', 'BreadController@viewCount');
                $api->post($dataTypes->slug.'/{id}/visits', 'BreadController@updateViewCount');
                //Route::resource($dataTypes->slug, 'BreadController');
            endforeach;
        endif;
    });
    $api->post('auth', 'ApiController@auth');

    /*$api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->post('fans', 'FansController@store');
        $api->get('fans', 'FansController@index');
        $api->delete('fans/{id}', 'FansController@delete');
    });*/
});
