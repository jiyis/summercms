<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/1/16
 * Time: 14:36
 * Desc:
 */

namespace App\Http\Controllers\Admin\Traits;


use App\Library\Complite\Compilate;
use App\Library\Complite\Handlers\BladeHandler;

trait PublishManage
{

    public function publishAllContent($category)
    {
        $build = new Compilate();
        $sourcePath = base_path('resources/views/templete') . $category;
        $buildPath = base_path('build');
        $build->registerHandler(new BladeHandler());
        $build->build($sourcePath, $buildPath, compact('data'));
    }

    /**
     * 根据url获取文件目录
     * @param $url
     * @return mixed|string
     */
    public function getDirByUrl($url)
    {
        if (empty(pathinfo($url, PATHINFO_EXTENSION))) {
            return '/'. ltrim($url);
        }

        return pathinfo($url, PATHINFO_DIRNAME);

    }
}