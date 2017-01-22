<?php
/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/6/2
 * Time: 11:16
 */

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\DataType;
use App\Models\Match;
use App\Models\Team;
use Illuminate\Http\Request;
use Breadcrumbs, Toastr;

class HomeController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Breadcrumbs::register('admin-home-index', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('个人面板', route('admin.home'));
        });
        $pdo     = \DB::connection()->getPdo();

        $version = $pdo->query('select version()')->fetchColumn();

        $data = [
            'server'          => $_SERVER['SERVER_SOFTWARE'],
            'http_host'       => $_SERVER['HTTP_HOST'],
            'remote_host'     => isset($_SERVER['REMOTE_HOST']) ? $_SERVER['REMOTE_HOST'] : $_SERVER['REMOTE_ADDR'],
            'user_agent'      => $_SERVER['HTTP_USER_AGENT'],
            'php'             => phpversion(),
            'sapi_name'       => php_sapi_name(),
            'extensions'      => implode(", ", get_loaded_extensions()),
            'db_connection'   => isset($_SERVER['DB_CONNECTION']) ? $_SERVER['DB_CONNECTION'] : 'Secret',
            'db_database'     => isset($_SERVER['DB_DATABASE']) ? $_SERVER['DB_DATABASE'] : 'Secret',
            'db_version'      => $version,
        ];
        //获取资讯数量
        $models = DataType::all();
        $data['news_count'] = 0;
        foreach ($models as $key => $value) {
            $model_name = $value->model_name;
            $data['news_count'] += $model_name::all()->count();
        }
        //获取所有栏目数
        $data['category_count'] = Category::all()->count();

        //获取所有的战队数量
        $data['team_count'] = Team::all()->count();

        //获取所有的赛事数

        $data['match_count'] = Match::all()->count();


        return view('admin.home', compact('data'));
    }
}
