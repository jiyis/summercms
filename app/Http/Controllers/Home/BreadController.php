<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/1/20
 * Time: 8:34
 * Desc:
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class BreadController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index(Request $request)
    {
        dd($request->all());
        $url = $request->segment(1);

        dd($url);

        if (empty(pathinfo($url, PATHINFO_EXTENSION))) {
           $url = 'ss';
        }


        return pathinfo($url, PATHINFO_DIRNAME);

        $dir_name = trim($this->getDirByUrl($url), '/');

        dd($dir_name);
        $view = 'templete.'.$slug. '.' .$dir_name;


        return view($view);

        // GET THE DataType based on the slug
        $dataType = DataType::where('slug', '=', $slug)->first();



        // Next Get the actual content from the MODEL that corresponds to the slug DataType
        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? call_user_func([$dataType->model_name, 'all'])
            : DB::table($dataType->name)->get(); // If Model doest exist, get data from table name

        $view = 'templete.'.$slug.'';

        if (view()->exists("admin.$slug.browse")) {
            $view = "admin.$slug.browse";
        } elseif (view()->exists("admin.$slug.browse")) {
            $view = "admin.$slug.browse";
        }
        return view($view, compact('dataType', 'dataTypeContent'));
    }

    public function content(Request $request)
    {

    }

}