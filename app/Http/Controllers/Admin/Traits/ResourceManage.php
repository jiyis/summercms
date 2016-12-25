<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/19
 * Time: 10:22
 * Desc:
 */

namespace App\Http\Controllers\Admin\Traits;

use File, Voyager;

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
     * @param $request
     * @throws
     */
    public function generatePage($url, $request)
    {
        if(empty($url) || empty($request)) throw new  \Exception('参数为空');
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
        $content = $this->getLayoutBlade($request->get('layout'), $this->combinSeo($request)) . $request->content;
        file_put_contents($page_path.strtolower($name).'.blade.php', $content);
    }

    /**
     * 生成栏目页面
     * @param $url
     * @param $templete
     * @param $request
     * @throws
     */
    public function generateCategory($url, $templete, $request)
    {
        if(empty($url) || empty($templete)) throw new \Exception('参数为空');
        $templete = \App\Models\Templete::where(['title' => $templete])->first();
        $content = $this->getLayoutBlade($templete->layout, $this->combinSeo($request)) . $templete->list;

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
     * @param $request
     * @throws
     */
    public function generateContent($url, $templete, $request)
    {
        if(empty($url) || empty($templete)) throw new \Exception('参数为空');
        $templete = \App\Models\Templete::where(['title' => $templete])->first();
        $content = $this->getLayoutBlade($templete->layout, $this->combinSeo($request)) . $templete->content;

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
     * @param string $seo
     * @return string
     */
    private function getLayoutBlade($layout, $seo)
    {
        return "@extends('layouts.".$layout."', ".$seo.")".PHP_EOL.PHP_EOL;
    }

    /**
     * 拼接组合SEO相关信息
     * @param $request
     * @return string
     */
    public function combinSeo($request)
    {

        $seo_title = $request->get('seo_title') ? $request->get('seo_title') : '';
        if(empty($seo_title)) {
            $seo_title = $request->get('title').' - ' .Voyager::setting('seo_title');
            $seo_keyword = $request->get('title').' - ' .Voyager::setting('seo_keyword');
            $seo_description = $request->get('title').' - ' .Voyager::setting('seo_description');
        }else{
            $seo_title = $request->get('seo_title') . '-' . Voyager::setting('seo_title');
            $seo_keyword = $request->get('seo_keyword') . '-' . Voyager::setting('seo_keyword');
            $seo_description = $request->get('seo_description') . '-' . Voyager::setting('seo_description');
        }
        return "['seo_title' => '".$seo_title."','seo_keyword' => '".$seo_keyword."','seo_description' => '".$seo_description."']";
    }
}