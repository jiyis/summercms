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

app('Dingo\Api\Http\RateLimit\Handler')->setRateLimiter(function ($app, $request) use($api) {

    $clientIP = $request->getClientIp();
    $whiteIps = explode(',', config('api.white_ip_list'));
    //如果是post过来的,并且在白名单之内
    if($request->isMethod('post')) {
        //dd($_SERVER['HTTP_REFERER']);
        if(in_array($clientIP, $whiteIps)){
            return $request->get('ip');
        }else{
            throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException('File Not Found.');
        }

    }
    return $clientIP;
});

$api->version('v1',['namespace' => '\App\Http\Controllers\Api\V1', 'middleware' => ['cors']], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit'      => config('api.rate_limits.access.limits'),
        'expires'    => config('api.rate_limits.access.expires'),
        'domain'     => config('api.domain')
    ], function($api) {

        $api->get('search','SearchController@search');
        //$api->get('pages', 'PageController@index');
        $api->get('match', 'MatchController@index');
        //报名信息
        $api->post('apply','ApplyController@store')->name('api.apply');

        if (config('database.default') !== null && Schema::hasTable('data_types')):
            foreach (App\Models\DataType::all() as $dataTypes):
                if($dataTypes->slug == 'menus') continue;
                $api->get($dataTypes->slug, 'BreadController@index');
                $api->post($dataTypes->slug, 'BreadController@index');
                $api->get($dataTypes->slug.'/{id}/visits', 'BreadController@viewCount');
                $api->post($dataTypes->slug.'/{id}/visits', 'BreadController@updateViewCount');
            endforeach;
        endif;
    });
    //$api->post('auth', 'ApiController@auth');

    /*$api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->post('fans', 'FansController@store');
        $api->get('fans', 'FansController@index');
        $api->delete('fans/{id}', 'FansController@delete');
    });*/
});
