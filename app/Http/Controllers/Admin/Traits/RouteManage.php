<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/1/22
 * Time: 15:38
 * Desc:
 */

namespace App\Http\Controllers\Admin\Traits;

use App\Models\Page;
use App\Models\Category;
use Route;

trait RouteManage
{

    /**
     * 更新所有的page页面的路由
     */
    public function generatePageRoute()
    {
        foreach (Page::all() as $item) {
            $url = trim($item->url, '/');
            if(empty($url)) continue;
            $pageRoutes[] = Route::get($url, function() use($url){
                if(empty(pathinfo($url, PATHINFO_EXTENSION))){
                    $templete = str_replace('/','.',$url);
                    return view('templete.'.$templete.'.index');
                }else{
                    return view('templete.'.pathinfo($url, PATHINFO_DIRNAME).'.'.pathinfo($url, PATHINFO_FILENAME));
                }
            });
        }
    }

    public function generateCategoryRoute()
    {
        //找到所有的栏目页
        $categories = Category::all();
        foreach ($categories as $item) {
            $url = trim($item->url, '/');
            if(empty($url)) continue;
            Route::get($url, function() use($url){
                if(empty(pathinfo($url, PATHINFO_EXTENSION))){
                    $templete = str_replace('/','.',$url);
                    return view('templete.'.$templete.'.index');
                }else{
                    return view('templete.'.pathinfo($url, PATHINFO_DIRNAME).'.'.pathinfo($url, PATHINFO_FILENAME));
                }
            });
        }
        //找到所有的内容页
        foreach ($categories->groupBy('model')->flatten() as $category) {
            $model = $category->getModel->model_name;
            $url = trim($category->url, '/');
            foreach ($model::all() as $data) {
                return view('templete.'.$url.'.'.$data->id.'.index');
            }
        }
    }

}