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

    public function handle($file, $data)
    {
        $filename = $file->getBasename('.blade.php') . '.html';
        return new ProcessedFile($filename, str_replace(resource_path('views/templete/'),'',$file->getPath()), $this->render($file, $data));
    }

    public function render($file, $data)
    {
        $name = str_replace(resource_path('views/'),'',$file->getPath());
        $name = str_replace('/','.',$name) . '.' . str_replace('.blade.php','',$file->getRelativePathname());

        return View::make($name)->render();
        //return $this->viewFactory->file($file->getRealPath(), $data)->render();
    }
}