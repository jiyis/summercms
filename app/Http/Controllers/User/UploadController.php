<?php

namespace App\Http\Controllers\User;

use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class UploadController extends Controller{

    public function imgUpload()
    {
        $form_data = Input::all();

        $photo = $form_data['avatar_file'];

        $original_name = $photo->getClientOriginalName();
        $original_name_without_ext = substr($original_name, 0, strlen($original_name) - 4);

        $filename = $this->sanitize($original_name_without_ext);
        $allowed_filename = $this->createUniqueFilename( $filename );

        $filename_ext = $allowed_filename .'.jpg';

        $manager = new ImageManager();
        $image = $manager->make( $photo )->encode('jpg')->save(env('APP_UPLOAD_PATH') . $filename_ext );
        if( !$image) {
            return Response::json([
                'status' => 'error',
                'message' => 'Server error while uploading',
            ], 200);

        }
        $image_url = env('APP_UPLOAD_PATH') . $filename_ext;
        $image_data = json_decode($form_data['avatar_data'],true);
        // resized sizes
        $imgW = (int)$image->width();
        $imgH = (int)$image->height();
        // offsets
        $imgY1 = (int)$image_data['x'];
        $imgX1 = (int)$image_data['y'];

        //crop size 
        $cropW = (int)$image_data['width'];
        $cropH = (int)$image_data['height'];
        // rotation angle
        $angle = (int)$image_data['rotate'];

        $manager = new ImageManager();
        $image = $manager->make( $image_url );
        $image->resize($imgW, $imgH)
            ->rotate(-$angle)
            ->crop($cropW, $cropH, $imgX1, $imgY1)
            ->save(env('APP_UPLOAD_PATH') .'avatar-'. $filename_ext );

        if( !$image) {
            return Response::json([
                'status' => 'error',
                'message' => 'Server error while uploading',
            ], 200);
        }

        $full_path = env('APP_UPLOAD_PATH') . $filename_ext ;
        if ( File::exists( $full_path ) )
        {
            File::delete( $full_path );
        }

        return Response::json([
            'status' => 'success',
            'url' => env('URL') . 'uploads/avatar-' . $filename_ext
        ], 200);
    }

    private function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    private function createUniqueFilename( $filename )
    {
        $upload_path = env('UPLOAD_PATH');
        $full_image_path = $upload_path . $filename . '.jpg';

        if ( File::exists( $full_image_path ) )
        {
            return time();
        }

        return time();
    }
}