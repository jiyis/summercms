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
use Illuminate\Database\Eloquent\Model;

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
        $this->saveBlade($layout_path.strtolower($name).'.blade.php', $content);
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
        $this->saveBlade($layout_path.strtolower($name).'.blade.php', $content);
    }

    /**
     * 生成Page文件
     * @param array $data  $data 为数组,可以是request过来的，也可以是自己传递的
     * @param Model $page  原有的page数据模型
     * @param array $seo   从seo数据表中独取出来的数据，可为数组也可为集合
     * @throws
     */
    public function generatePage(array $data, Model $page, $seo = [])
    {
        $url = $data['url'];
        if(empty($url) || empty($page)) throw new  \Exception('参数为空');
        $path = $this->getDirName($url);
        $name = $path['name'];
        $dirname = $path['dirname'];
        //如果url改变，删除旧的数据
        if(!empty($page) && $data['url'] != $page->url) $this->delOldHtml($page);
        $page_path = base_path('resources/views/templete/') . ltrim($dirname, '/') . '/';
        if(!is_dir($page_path)){
            File::makeDirectory($page_path, 493, true);
        }
        $content = $this->getLayoutBlade($data['layout'], $this->generateSeo($seo, $data)) . $data['content'];
        $this->saveBlade($page_path.strtolower($name).'.blade.php', $content);
    }

    /**
     * 生成栏目页面
     * @param array $data
     * @param Model $category
     * @param array $seo
     * @throws
     */
    public function generateCategory(array $data, Model $category,  $seo = [])
    {
        $url = $data['url'];
        if(empty($url) || empty($category)) throw new \Exception('参数为空');
        $titleurl = '/'.$url.'/{{$item->id}}';
        $templete = $category->getTemplete;
        $templete->list =  str_replace(['[[$category_id]]','[[$titleurl]]','[[$category_name]]'],[$category->id, $titleurl, $data['title']], $templete->list);
        $content = $this->getLayoutBlade($templete->layout, $this->generateSeo($seo, $data)) . $templete->list;

        $url = $this->prettyUrl($url);
        $path = $this->getDirName($url);
        $name = $path['name'];
        $dirname = $path['dirname'];

        $page_path = base_path('resources/views/templete/') . ltrim($dirname, '/') . '/';
        if(!is_dir($page_path)){
            File::makeDirectory($page_path, 493, true);
        }
        $this->saveBlade($page_path.strtolower($name).'.blade.php', $content);
    }

    /**
     * 生成内容页面
     * @param string $url
     * @param array $data
     * @param Model $content
     * @param array $seo
     * @throws
     */
    public function generateContent($url, array $data, Model $content, array $seo =[])
    {
        if(empty($url) || empty($content)) throw new \Exception('参数为空');
        $content = $this->getLayoutBlade($content->getCategory->getTemplete->layout,  $this->generateSeo($seo, $data)) . $content->getCategory->getTemplete->content;

        $url = $this->prettyUrl($url);
        $path = $this->getDirName($url);
        $name = $path['name'];
        $dirname = $path['dirname'];

        $page_path = base_path('resources/views/templete/') . ltrim($dirname, '/') . '/';
        if(!is_dir($page_path)){
            File::makeDirectory($page_path, 493, true);
        }
        $this->saveBlade($page_path.strtolower($name).'.blade.php', $content);
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
     * @param $seo
     * @return array
     */
    public function generateSeo($seo, array $data)
    {
        //如果seo为空，则尝试从$data里面获取,$data可能来源于request，也可能来源于自定义数组
        if(empty($seo)) {
            //如果是从reques里面来的
            if(isset($data['seo_title'])) {
                $seo['seo_title'] = isset($data['seo_title']) ? $data['seo_title'] : '';
                $seo['seo_keyword'] = isset($data['seo_keyword']) ? $data['seo_keyword'] : '';
                $seo['seo_description'] = isset($data['seo_description']) ? $data['seo_description'] : '';
                $seo['title'] = $data['title'];
            }elseif(isset($data['title'])) {  //如果不是从request里面获取而来的
                $seo['seo_title'] = $data['title'];
                $seo['seo_keyword'] = $data['title'];
                $seo['seo_description'] = $data['title'];
            }else{
                $seo['seo_title'] = '';
                $seo['seo_keyword'] = '';
                $seo['seo_description'] = '';
            }
        }

        return $this->combinSeo($seo);
    }

    /**
     * 拼接组合SEO相关信息
     * @param $seo
     * @return string
     */
    public function combinSeo($seo)
    {
        if(!empty($seo)) {
            $seo_title = $seo['seo_title'].' - ' .Voyager::setting('seo_title');
            $seo_keyword = $seo['seo_keyword'].' - ' .Voyager::setting('seo_keyword');
            $seo_description = $seo['seo_description'].' - ' .Voyager::setting('seo_description');
        }else{
            $seo_title = Voyager::setting('seo_title');
            $seo_keyword = Voyager::setting('seo_keyword');
            $seo_description = Voyager::setting('seo_description');
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
        $path = $this->getDirName($url);
        $name = $path['name'];
        $dirname = $path['dirname'];
        $register_path = base_path('resources/views/templete/') . ltrim($dirname, '/') . '/';
        if(!is_dir($register_path)){
            File::makeDirectory($register_path, 493, true);
        }
        $this->saveBlade($register_path.strtolower($name).'.blade.php', $content);
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
            $inputs.= '<td><input type="text" name="register[{{$index}}]['.array_search($column,$mapping).']" class="form-control" id="register[{{$index}}][]" required="required"></td>';
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

    /**
     *
     * @param $data
     * @return mixed
     */
    public function standUrl($data)
    {
        if($data['url'] != '/') $data['url'] = trim($data['url'], '/');
        return $data;
    }

    /**
     * 因为blade会自动解析@parent，所以改为@father
     * @param $file_name
     * @param $content
     * @return int
     */
    public function saveBlade($file_name, $content)
    {
        return file_put_contents($file_name, str_replace(['@father'],['@parent'],$content));
    }

    /**
     * 根据url获取文件名和文件夹路径
     * @param $url
     * @return array
     */
    public function getDirName($url)
    {
        if (empty(pathinfo($url, PATHINFO_EXTENSION))) {
            return [
                'name'    => 'index',
                'dirname' => $url
            ];
        }
        return [
            'name'    => pathinfo($url, PATHINFO_FILENAME),
            'dirname' => pathinfo($url, PATHINFO_DIRNAME)
        ];
    }

    /**
     * 删除因为url改变而产生的旧的html文件
     * @param $data
     */
    public function delOldHtml($data)
    {
        if (empty(pathinfo($data->url, PATHINFO_EXTENSION))) {
            $deldirname = $data->url;
        } else{
            $deldirname = pathinfo($data->url, PATHINFO_DIRNAME);
        }
        if(!empty(trim($deldirname, '/'))) File::deleteDirectory(base_path('resources/views/templete/') . ltrim($deldirname, '/'));
    }
}