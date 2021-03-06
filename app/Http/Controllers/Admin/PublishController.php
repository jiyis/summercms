<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/20
 * Time: 11:02
 * Desc:
 */

namespace App\Http\Controllers\Admin;

use App\Contracts\CompliteInterface;
use App\Http\Controllers\Admin\Traits\PublishManage;
use App\Library\Complite\Compilate;
use App\Library\Complite\Handlers\BladeHandler;
use App\Library\Complite\Filesystem;
use App\Services\CommonServices;
use Illuminate\Http\Request;

class PublishController extends BaseController implements CompliteInterface
{
    use PublishManage;

    private $build;
    private $files;

    public function __construct(Compilate $build, Filesystem $files)
    {
        parent::__construct();
        $this->build = $build;
        $this->files = $files;
        $this->build->registerHandler(new BladeHandler());
    }

    /**
     * 发布网页
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(Request $request)
    {

        $url = $request->get('url');
        $dirname = $this->getDirByUrl($url);
        $data = [];
        //如果指定了模型，则代表不是自定义页面，可以传递数据到视图
        if($request->get('model')){
            $model = $request->get('model');
            $data = $model::find($request->get('id'));
        }
        $sourcePath = base_path('resources/views/templete') . $dirname;
        $buildPath = base_path('build');
        $this->build->build($sourcePath, $buildPath, compact('data'),0);
        return response()->json(['status' => 1]);
    }

    /**
     * 发布所有的page单页面，包括首页
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishPage(Request $request)
    {
        $pages = CommonServices::getPages();
        foreach ($pages as $page) {
            $url = $page->url;
            $dirname = $this->getDirByUrl($url);
            $sourcePath = base_path('resources/views/templete') . $dirname;
            $buildPath = base_path('build');
            $this->build->build($sourcePath, $buildPath, [],0);
        }
        return response()->json(['status' => 1]);
    }

    /**
     * 发布所有的栏目页面
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishCategory(Request $request)
    {
        $categories = CommonServices::getCategory();
        foreach ($categories as $category) {
            $url = $category->url;
            $dirname = $this->getDirByUrl($url);
            $sourcePath = base_path('resources/views/templete') . $dirname;
            $buildPath = base_path('build');
            $this->build->build($sourcePath, $buildPath, [],0);
        }
        return response()->json(['status' => 1]);
    }

    /**
     * 更新新建的模型的文件
     * @param Request $request
     * @return mixed
     */
    public function publishModel(Request $request)
    {
        $this->generateModel();
        return response()->json(['status' => 1]);
    }

    /**
     * 删除前台目录的存在的已过期或者不存在的html页面
     * @param Request $request
     */
    public function publishBuild(Request $request)
    {
        $sourcePath = base_path('build');
        $files = $this->files->getFiles($sourcePath, ['dist','uploads','action']);
        dd($files);
    }

    /**
     * 刷新数据库的缓存文件，刷新模型文件
     * @param Request $request
     * @return mixed
     */
    public function publishBlade(Request $request)
    {
        $this->generateModel();
        $this->generateBlade();
        return response()->json(['status' => 1]);
    }



    //todo  后续发布机制需要完善下
    public function publishAllContent(Request $request)
    {
        try{
            //如果没有指定模型和url，那么就全部发布
            if (!$request->get('url') && !$request->get('model')){
                $categories = CommonServices::getCategory();
                foreach ($categories as $category) {
                    $url = $category->url;
                    $dirname = $this->getDirByUrl($url);
                    $sourcePath = base_path('resources/views/templete') . $dirname;
                    $buildPath = base_path('build');
                    $model = $category->getModel->model_name;
                    foreach ($model::all() as $item) {
                        $data = $item;
                        $this->build->build( $sourcePath . '/' . $item->id, $buildPath, compact('data'),0);
                    }
                }
            }else{
                $dirname = $this->getDirByUrl($request->get('url'));
                $sourcePath = base_path('resources/views/templete') . $dirname;
                $buildPath = base_path('build');
                $model = $request->get('model');
                foreach ($model::all() as $item) {
                    $data = $item;
                    $this->build->build( $sourcePath . '/' . $item->id, $buildPath, compact('data'),0);
                }
            }
            return response()->json(['status' => 1]);
        }catch (\Exception $e){
            return response()->json(['status' => -1, 'msg' => $e->getMessage()]);
        }

    }


}