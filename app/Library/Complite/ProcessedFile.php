<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/20
 * Time: 13:18
 * Desc:
 */

namespace App\Library\Complite;


class ProcessedFile
{
    private $name;
    private $relativePath;
    private $contents;

    public function __construct($name, $relativePath, $contents)
    {
        $this->name = $name;
        $this->relativePath = $relativePath;
        $this->contents = $contents;
    }

    public function name()
    {
        return $this->name;
    }

    public function basename()
    {
        return pathinfo($this->name, PATHINFO_FILENAME);
    }

    public function extension()
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    public function relativePath()
    {
        return $this->relativePath;
    }

    public function relativePathname()
    {
        return "{$this->relativePath}/{$this->name}";
    }

    public function contents()
    {
        return $this->contents;
    }
}