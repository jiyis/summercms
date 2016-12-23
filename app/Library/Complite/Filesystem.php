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
    /**
     * 遍历当前目录以及子目录下所有的文件
     * @param string $directory
     * @param int $depth
     * @param bool $hidden
     * @return array
     */
    public function allFiles($directory, $depth = 10, $hidden = false)
    {
        return iterator_to_array(Finder::create()->ignoreDotFiles($hidden)->depth($depth)->files()->in($directory), false);
    }
}