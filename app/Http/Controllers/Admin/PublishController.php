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
use App\Library\Complite\Compilate;
use App\Library\Complite\Handlers\BladeHandler;
use Illuminate\Http\Request;

class PublishController extends BaseController implements CompliteInterface
{
    private $build;

    public function __construct(Compilate $build)
    {
        parent::__construct();
        $this->build = $build;
        $this->build->registerHandler(new BladeHandler());
    }

    public function publish(Request $request)
    {

        $url = $request->get('url');
        if (empty(pathinfo($url, PATHINFO_EXTENSION))) {
            $dirname = '/'. ltrim($url);
        } else{
            $dirname = pathinfo($url, PATHINFO_DIRNAME);
        }
        $data = [];
        if($request->get('model')){
            $model = $request->get('model');
            $data = $model::find($request->get('id'));
        }
        $sourcePath = base_path('resources/views/templete') . $dirname;
        $buildPath = base_path('build');
        $this->build->build($sourcePath, $buildPath, compact('data'),0);
        return response()->json(['status' => 1]);
    }
    //todo  后续发布机制需要完善下
    public function publishAllContent(Request $request)
    {
        $category = $request->get('url');
        $sourcePath = base_path('resources/views/templete') . '/' . trim($category,'/');
        $buildPath = base_path('build');
        $model = $request->get('model');
        foreach ($model::all() as $item) {
            $data = $item;
            $this->build->build( $sourcePath . '/' . $item->id, $buildPath, compact('data'),0);
        }
        return response()->json(['status' => 1]);
    }
}