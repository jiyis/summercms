<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/20
 * Time: 13:20
 * Desc:
 */

namespace App\Library\Complite\Handlers;

use Illuminate\Contracts\View\Factory;
use App\Library\Complite\ProcessedFile;
use View;

class BladeHandler
{
    public function __construct()
    {

    }

    public function canHandle($file)
    {
        return ends_with($file->getFilename(), '.blade.php');
    }

    public function handle($file, $data, $extension = '.html')
    {
        $filename = $file->getBasename('.blade.php') . $extension;
        $basepath = str_replace('\\','/',resource_path('views/templete/'));
        $fullpath = str_replace(['\\','//'],['/','/'],$file->getPath());
        return new ProcessedFile($filename, str_replace($basepath,'',$fullpath), $this->render($file, $data));
    }

    public function render($file, $data)
    {
        $basepath = str_replace('\\','/',resource_path('views/'));
        $fullpath = str_replace(['\\','//'],['/','/'],$file->getPath());
        $name = str_replace($basepath,'',$fullpath);
        $name = str_replace('/','.',$name) . '.' . str_replace('.blade.php','',$file->getFilename());

        return View::make($name, $data)->render();
        //return $this->viewFactory->file($file->getRealPath(), $data)->render();
    }
}