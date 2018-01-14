<?php
/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/6/24
 * Time: 17:02
 */

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Services\UploadManager;
use App\Http\Controllers\Controller;
use File;

class UploadController extends Controller
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
            $this->validate($request,[
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);
            $name     = $request->get('name');
            $file     = $request->file('file');

            $datepath = date('Ymd', time());
            $extName  = $file->getClientOriginalExtension();
            $fileName = empty($name) ? time() . str_random(3) : $name . '-' . str_random(3);
            $lastpath = storage_path('app/public/') . config('custom.images') . str_finish($datepath, '/');
            if (!is_dir($lastpath)) {
                File::makeDirectory($lastpath, 0755, true);
            }
            $filepath = $lastpath . $fileName . '.' . $extName;
            $content  = $file->getPathname();
            //判断是否有指定尺寸以及缩略图
            $result = $this->manager->saveImage($filepath, $content);
            if (!empty($request->get('details'))){
                $options = json_decode($request->get('details'));
                if (isset($options->resize) && isset($options->resize->width) && isset($options->resize->height)) {
                    $resize_width = $options->resize->width;
                    $resize_height = $options->resize->height;
                    $result = $this->manager->saveImage($filepath, $content, $resize_width, $resize_height, true);
                }
                //检查是否有缩略图选项
                if(isset($options->thumbnails)) {
                    foreach ($options->thumbnails as $thumbnail) {
                        foreach ($thumbnail->crop as $crop) {
                            if(isset($crop->width) && isset($crop->height)) {
                                $crop_width = $crop->width;
                                $crop_height = $crop->height;
                                $thumbpath =  $lastpath . $fileName . '_'.$crop_width.'_'.$crop_height.'.'.$extName;
                                $this->manager->saveImage($thumbpath, $content, $crop_width, $crop_height, true);
                            }
                        }
                    }
                }
            }
            $path = $this->manager->filepath($result->basename, config('custom.images') . str_finish($datepath, '/'));
            return response()->json(['msg' => 'success', 'code' => '1', 'path' => '/'.ltrim($path, '/')]);
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
            $lastpath = storage_path('app/public/') . config('custom.files') . str_finish($datepath, '/');

            if (!is_dir($lastpath)) {
                File::makeDirectory($lastpath, 0755, true);
            }
            //$content =$file->getPathname();
            $result = $file->move($lastpath, $fileName);
            //$path   = $result->getPathname();

            //$path   = str_replace('\\', '/', $path);
            $path = config('custom.files') . str_finish($datepath, '/').$fileName;
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
            File::delete(storage_path('app/public') . $file);
            return response()->json(['msg' => 'success', 'code' => '1']);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'code' => '0']);
        }
    }

}