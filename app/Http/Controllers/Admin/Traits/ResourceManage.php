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
     * 生成前台Layout小部件文件
     * @param $name
     * @param $content
     * @throws
     */
    public function generatePartial($name, $content)
    {
        if(empty($name) || empty($content)) throw new  \Exception('参数为空');
        $layout_path = base_path('resources/views/partials/');
        if(!is_dir($layout_path)){
            File::makeDirectory($layout_path, 493, true);
        }
        file_put_contents($layout_path.strtolower($name).'.blade.php', $content);
    }

    /**
     * 生成Page文件
     * @param $page
     * @param $request
     * @throws
     */
    public function generatePage($page, $request)
    {
        $url = $request->get('url');
        if(empty($url) || empty($request)) throw new  \Exception('参数为空');
        if (empty(pathinfo($url, PATHINFO_EXTENSION))) {
            $name = 'index';
            $dirname = $url;
        } else{
            $name = pathinfo($url, PATHINFO_FILENAME);
            $dirname = pathinfo($url, PATHINFO_DIRNAME);
        }
        //如果url改变，删除旧的数据
        if($request->get('url') != $page->url){
            if (empty(pathinfo($page->url, PATHINFO_EXTENSION))) {
                $deldirname = $page->url;
            } else{
                $deldirname = pathinfo($page->url, PATHINFO_DIRNAME);
            }

            if(!empty(trim($deldirname, '/'))) File::deleteDirectory(base_path('resources/views/templete/') . ltrim($deldirname, '/'));
        }
        $page_path = base_path('resources/views/templete/') . ltrim($dirname, '/') . '/';
        if(!is_dir($page_path)){
            File::makeDirectory($page_path, 493, true);
        }
        $content = $this->getLayoutBlade($request->get('layout'), $this->combinSeo($request->all())) . $request->content;
        file_put_contents($page_path.strtolower($name).'.blade.php', $content);
    }

    /**
     * 生成栏目页面
     * @param $id
     * @param array $data
     * @param $templete
     * @param array $seo
     * @throws
     */
    public function generateCategory($templete, array $data, $id, array $seo = [])
    {
        $url = $data['url'];
        if(empty($url) || empty($templete)) throw new \Exception('参数为空');
        //$model_name = $data['model'];
        //$model = \App\Models\DataType::where(['name' => $model_name])->first(['model_name'])->model_name;
        $titleurl = '/'.$url.'/{{$item->id}}';

        $templete->list =  str_replace(['[[$category_id]]','[[$titleurl]]','[[$category_name]]'],[$id, $titleurl, $data['title']], $templete->list);
        $content = $this->getLayoutBlade($templete->layout, $this->generateSeo($data, $seo)) . $templete->list;

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
     * @param array $data
     * @param array $seo
     * @throws
     */
    public function generateContent($url, $templete, $data, array $seo =[])
    {
        if(empty($url) || empty($templete)) throw new \Exception('参数为空');
        $content = $this->getLayoutBlade($templete->layout,  $this->generateSeo($data, $seo)) . $templete->content;

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
     * 根据seo传递来源，对seo数据进行封装
     * @param array $data
     * @param array $seo
     * @return array
     */
    public function generateSeo(array $data, array $seo)
    {
        //如果seo为空，则尝试从$data里面获取
        if(empty($seo)) {
            $seo['seo_title'] = isset($data['seo_title']) ? $data['seo_title'] : '';
            $seo['seo_keyword'] = isset($data['seo_keyword']) ? $data['seo_keyword'] : '';
            $seo['seo_description'] = isset($data['seo_description']) ? $data['seo_description'] : '';
        }
        $seo['title'] = $data['title'];
        return $this->combinSeo($seo);
    }

    /**
     * 拼接组合SEO相关信息
     * @param array $data
     * @return string
     */
    public function combinSeo(array $data)
    {

        $seo_title = $data['seo_title'] ? $data['seo_title'] : '';
        if(empty($seo_title)) {
            $seo_title = $data['title'].' - ' .Voyager::setting('seo_title');
            $seo_keyword = $data['title'].' - ' .Voyager::setting('seo_keyword');
            $seo_description = $data['title'].' - ' .Voyager::setting('seo_description');
        }else{
            $seo_title = $data['seo_title'] . '-' . Voyager::setting('seo_title');
            $seo_keyword = $data['seo_keyword'] . '-' . Voyager::setting('seo_keyword');
            $seo_description = $data['seo_description'] . '-' . Voyager::setting('seo_description');
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
            $rows.= '<tr><td style="width: 50px;">' . $row . '</td>'.$current.'</tr>';
        }

        return <<<EOF
            <table class="member-list">
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