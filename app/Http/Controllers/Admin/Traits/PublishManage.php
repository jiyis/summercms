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
use Illuminate\Support\Facades\Artisan;
use App\Models\Category;
use App\Models\DataType;
use App\Models\Layout;
use App\Models\Page;
use App\Models\Partial;
use App\Models\Seo;

trait PublishManage
{

    use ResourceManage;
    /**
     * 发布所有内容页
     * @param $category
     */
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

    /**
     * 从外部带入数据库时候，生成所有的blade页面
     * @throws \Exception
     */
    public function generateBlade()
    {
        //生成所有的layout页面
        $layouts = Layout::all();
        foreach ($layouts as $layout) {
            $this->generateLayout($layout->title, $layout->content);
        }
        //生成所有的partials
        $partials = Partial::all();
        foreach ($partials as $partial) {
            $this->generatePartial($partial->title, $partial->content);
        }
        //生成所有的自定义页面
        $pages = Page::all();
        foreach ($pages as $page) {
            $seo = Seo::where(['seo_type' => 'page', 'associ_id' => $page->id])->first();
            $this->generatePage($page->toArray(), $page, $seo);
        }
        //生成所有的栏目页
        $categories = Category::all();
        foreach ($categories as $category) {
            $seo = Seo::where(['seo_type' => 'category', 'associ_id' => $category->id])->first();
            $this->generateCategory($category->toArray(), $category, $seo);
        }
        //生成所有的内容页
        foreach ($categories->groupBy('model')->flatten() as $category) {
            $model = $category->getModel->model_name;
            foreach ($model::all() as $data) {
                $this->generateContent($category->url . '/' . $data->id ,$data->toArray(), $data, []);
            }
        }
    }

    /**
     * 刷新自定义模型文件
     */
    public function generateModel()
    {
        $models = DataType::all();
        foreach ($models as $key => $value) {
            $model_name = last(explode('\\', $value->model_name));
            $table_name = $value->name;
            \File::delete(app_path('/Models/').$model_name.'.php');
            Artisan::call('generate:model', [
                'name' => 'Models/'.$model_name,
                '--table' => $table_name,
            ]);
        }
    }
}