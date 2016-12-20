<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/19
 * Time: 10:22
 * Desc:
 */

namespace App\Http\Controllers\Admin\Traits;

use File;

trait ResourceManage
{

    /**
     * 生成前台Layout布局文件
     * @param $name
     * @param $content
     * @throws
     */
    public function generateLayout($name, $content)
    {
        if(empty($name) || empty($content)) throw new  \Exception('参数为空');
        $layout_path = base_path('resources/views/layouts/');
        if(!is_dir($layout_path)){
            File::makeDirectory($layout_path, 493, true);
        }
        file_put_contents($layout_path.strtolower($name).'.balde.php', $content);
    }

    /**
     * 生成Page文件
     * @param $url
     * @param $content
     * @throws
     */
    public function generatePage($url, $content)
    {
        if(empty($url) || empty($content)) throw new  \Exception('参数为空');
        if (empty(pathinfo($url, PATHINFO_EXTENSION))) {
            $name = 'index';
        } else{
            $name = pathinfo($url, PATHINFO_FILENAME);
        }
        $dirname = pathinfo($url, PATHINFO_DIRNAME);
        $page_path = base_path('resources/views/templete/') . ltrim($dirname, '/') . '/';
        if(!is_dir($page_path)){
            File::makeDirectory($page_path, 493, true);
        }
        file_put_contents($page_path.strtolower($name).'.blade.php', $content);
    }
}