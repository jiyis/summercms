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

    });
    $api->post('auth', 'ApiController@auth');
    $api->get('pages', 'PageController@index');
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->post('fans', 'FansController@store');
        $api->get('fans', 'FansController@index');
        $api->delete('fans/{id}', 'FansController@delete');
    });
});
