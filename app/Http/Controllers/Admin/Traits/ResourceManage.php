<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/19
 * Time: 10:22
 * Desc:
 */

namespace App\Http\Controllers\Admin\Traits;

use App\Models\DataType;
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
     * @param $id
     * @param $request
     * @throws
     */
    public function generateCategory($request, $id)
    {
        $url = $request->get('url');
        $templete = $request->get('template');
        if(empty($url) || empty($templete)) throw new \Exception('参数为空');
        $templete = \App\Models\Templete::where(['title' => $templete])->first();
        $model = $request->get('model');
        $templete->list =  str_replace(['[[$data]]','[[$titleurl]]'],["\\App\\Models\\DataType::where(['name' => '$model'])->first(['model_name'])->model_name::where(['category_id' => $id])->get()", $url], $templete->list);
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

    /**
     * 生成前台报名文件
     * @param $url
     * @param $content
     * @throws
     * @return string
     */
    public function generateRegister($url, $content)
    {
        if(empty($url) || empty($content)) throw new  \Exception('参数为空');

        $url = $this->prettyUrl($url);
        if (empty(pathinfo($url, PATHINFO_EXTENSION))) {
            $name = 'index';
            $dirname = $url;
        } else{
            $name = pathinfo($url, PATHINFO_FILENAME);
            $dirname = pathinfo($url, PATHINFO_DIRNAME);
        }
        $register_path = base_path('resources/views/templete/') . ltrim($dirname, '/') . '/';
        if(!is_dir($register_path)){
            File::makeDirectory($register_path, 493, true);
        }
        file_put_contents($register_path.strtolower($name).'.blade.php', $content);
        return $dirname;
    }

    /**
     * 动态生成报名表单
     * @param $apply
     * @return bool|void
     */
    public function generateTable($apply)
    {
        if(empty($apply)) return false;
        $columns = $rows = $inputs = '';
        $mapping = json_decode($apply->mapping, true);

        foreach (explode('||', $apply->column) as  $column) {
            $columns.= '<th>' . $column . '</th>';
            $inputs.= '<td><input type="text" name="register[{{$index}}]['.array_search($column,$mapping).']" class="form-control" required="required"></td>';
        }
        foreach (explode('||', $apply->row) as $index => $row) {
            $current = str_replace('{{$index}}',$index, $inputs);
            $rows.= '<tr><td>' . $row . '</td>'.$current.'</tr>';
        }

        return <<<EOF
        <table class="table  table-bordered table-hover">
            <thead>
            <tr>
                <th></th>
                {$columns}
            </tr>
            </thead>
            <tbody>
                {$rows}
            </tbody>
        </table>
EOF;
    }
}