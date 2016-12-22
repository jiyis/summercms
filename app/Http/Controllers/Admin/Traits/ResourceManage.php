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
        file_put_contents($layout_path.strtolower($name).'.blade.php', $content);
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

    /**
     * 生成栏目页面
     * @param $url
     * @param $templete
     * @throws
     */
    public function generateCategory($url, $templete)
    {
        if(empty($url) || empty($templete)) throw new \Exception('参数为空');
        $templete = \App\Models\Templete::where(['title' => $templete])->first();
        $content = $this->getLayoutBlade($templete->layout) . $templete->list;

        $url = $this->prettyUrl($url);
        if (empty(pathinfo($url, PATHINFO_EXTENSION))) {
            $name = 'index';
            $dirname = $url;
        } else{
            $name = pathinfo($url, PATHINFO_FILENAME);
            $dirname = pathinfo($url, PATHINFO_DIRNAME);
        }

        $page_path = base_path('resources/views/templete/') . ltrim($dirname, '/') . '/';
        if(!is_dir($page_path)){
            File::makeDirectory($page_path, 493, true);
        }
        file_put_contents($page_path.strtolower($name).'.blade.php', $content);
    }

    /**
     * 生成内容页面
     * @param $url
     * @param $templete
     * @throws
     */
    public function generateContent($url, $templete)
    {
        if(empty($url) || empty($templete)) throw new \Exception('参数为空');
        $templete = \App\Models\Templete::where(['title' => $templete])->first();
        $content = $this->getLayoutBlade($templete->layout) . $templete->content;

        $url = $this->prettyUrl($url);
        if (empty(pathinfo($url, PATHINFO_EXTENSION))) {
            $name = 'index';
            $dirname = $url;
        } else{
            $name = pathinfo($url, PATHINFO_FILENAME);
            $dirname = pathinfo($url, PATHINFO_DIRNAME);
        }

        $page_path = base_path('resources/views/templete/') . ltrim($dirname, '/') . '/';
        if(!is_dir($page_path)){
            File::makeDirectory($page_path, 493, true);
        }
        file_put_contents($page_path.strtolower($name).'.blade.php', $content);
    }
    /**
     * 规范化url
     * @param $url
     * @return string
     */
    private function prettyUrl($url){
        return '/' . ltrim($url,'/');
    }

    /**
     * 拼接balde模版的layout
     * @param $layout
     * @return string
     */
    private function getLayoutBlade($layout)
    {
        return "@extends('layouts.".$layout."')".PHP_EOL.PHP_EOL;
    }
}