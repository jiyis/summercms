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
    public function allFiles($directory, $depth = 5, $hidden = false)
    {
        return iterator_to_array(Finder::create()->ignoreDotFiles($hidden)->depth($depth)->files()->in($directory), false);
    }

    /**
     * 根据传递的条件获取目录下的文件
     * @param $directory
     * @param array $ignores
     * @param string $depth
     * @param string $name
     * @param bool $hidden
     * @return mixed
     */
    public function getFiles($directory, array $ignores = [], $name = '', $depth = '', $hidden = false)
    {
        //实例化Finder类，默认不查找.开头的文件
        $finder = Finder::create()->ignoreDotFiles($hidden);

        //如果传递了$ignores，则循环忽略执行的文件夹名，比如 $ignores = ['uploads']
        foreach ($ignores as $key => $value) {
            $finder = $finder->notPath($value);
        }

        //如果传递了$depth，则根据$depth的值去查找文件，比如$depth=1，查找目录为/www/，则会查找/www/news/xxx.php 这样的文件
        if($depth != '') $finder = $finder->depth($depth);

        //如果传递了$name，则查找跟$name相匹配的文件名,例如$name = '*.php' 则只查找php文件
        if($name != '') $finder = $finder->name($name);

        return iterator_to_array($finder->files()->in($directory), false);

    }
}