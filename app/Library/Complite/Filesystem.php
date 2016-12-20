<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/20
 * Time: 11:20
 * Desc:
 */

namespace App\Library\Complite;

use Illuminate\Filesystem\Filesystem as BaseFilesystem;
use Symfony\Component\Finder\Finder;

class Filesystem extends BaseFilesystem
{

    public function allFiles($directory, $hidden = false)
    {
        return iterator_to_array(Finder::create()->ignoreDotFiles($hidden)->files()->in($directory), false);
    }
}