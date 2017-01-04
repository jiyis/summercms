<?php
/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/6/24
 * Time: 17:02
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UploadManager;
use File;

class UploadController extends BaseController
{
    protected  $manager;

    public function __construct(UploadManager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        try {
            $name     = $request->get('name');
            $file     = $request->file('file');
            $datepath = date('Ymd', time());
            $extName  = $file->getClientOriginalExtension();
            $fileName = empty($name) ? time() . str_random(3) . '.' . $extName : $name . '-' . str_random(3) . '.' . $extName;
            $lastpath = public_path() . config('common.images') . str_finish($datepath, '/');
            if (!is_dir($lastpath)) {
                File::makeDirectory($lastpath, 0755, true);
            }
            $filepath = $lastpath . $fileName;
            $content  = $file->getPathname();
            if ($name == 'userpic') {
                $result = $this->manager->saveImage($filepath, $content, 125, 165, true);
            } else {
                $result = $this->manager->saveImage($filepath, $content);
            }
            $path = $this->manager->filepath($result->basename, config('common.images') . str_finish($datepath, '/'));
            return response()->json(['msg' => 'success', 'code' => '1', 'path' => $path]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'code' => '0']);
        }

    }

    /**
     * 上传附件或者视频
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFile(Request $request)
    {
        try {
            $name     = $request->get('name');
            $file     = $request->file('file');
            $datepath = date('Ymd', time());
            $extName  = $file->getClientOriginalExtension();
            $fileName = empty($name) ? time() . str_random(3) . '.' . $extName : $name . '-' . str_random(3) . '.' . $extName;
            $lastpath = public_path() . config('common.files') . str_finish($datepath, '/');
            if (!is_dir($lastpath)) {
                File::makeDirectory($lastpath, 0755, true);
            }
            //$content =$file->getPathname();
            $result = $file->move($lastpath, $fileName);
            $path   = $result->getPathname();
            $path   = str_replace('\\', '/', $path);
            return response()->json(['msg' => 'success', 'code' => '1', 'path' => $path]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'code' => '0']);
        }
    }

    /**
     * 删除上传的文件
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile(Request $request)
    {
        try {
            $file = $request->get('name');
            //$result = $this->manager->deleteFiles($file);
            File::delete(public_path() . $file);
            return response()->json(['msg' => 'success', 'code' => '1']);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'code' => '0']);
        }
    }

}