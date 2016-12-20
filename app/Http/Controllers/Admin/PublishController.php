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

        $sourcePath = base_path('resources/views/templete') . pathinfo($request->get('url'), PATHINFO_DIRNAME);
        $buildPath = base_path('build');
        $this->build->build($sourcePath, $buildPath);
        return response()->json(['status' => 1]);
    }
}