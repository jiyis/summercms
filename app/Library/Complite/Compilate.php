<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/20
 * Time: 11:17
 * Desc:
 */

namespace App\Library\Complite;

class Compilate
{

    private $files;

    private $cachePath;

    private $handlers = [];

    private $options = [
        'pretty' => true
    ];

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->cachePath = base_path('_tmp');
    }

    public function registerHandler($handler)
    {
        $this->handlers[] = $handler;
    }

    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    /**
     * 编译指定目录下的模版文件
     * @param $source
     * @param $dest
     * @param array $config
     */
    public function build($source, $dest, $config = [])
    {
        $this->prepareDirectories([$this->cachePath]);
        $this->buildSite($source, $dest, $config);
        $this->cleanup();
    }

    /**
     * 循环创建文件夹
     * @param $directories
     */
    private function prepareDirectories($directories)
    {
        foreach ($directories as $directory) {
            $this->prepareDirectory($directory, true);
        }
    }

    /**
     * 创建文件夹
     * @param $directory
     * @param bool $clean
     */
    private function prepareDirectory($directory, $clean = false)
    {
        if (! $this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        if ($clean) {
            $this->files->cleanDirectory($directory);
        }
    }

    /**
     * 循环编译目录生成静态文件
     * @param $source
     * @param $dest
     * @param $config
     */
    private function buildSite($source, $dest, $config)
    {
        collect($this->files->allFiles($source, 0))->filter(function ($file) {
            return ! $this->shouldIgnore($file);
        })->each(function ($file) use ($dest, $config) {
            $this->buildFile($file, $dest, $config);
        });
    }

    /**
     * 删除缓存目录
     */
    private function cleanup()
    {
        $this->files->deleteDirectory($this->cachePath);
    }

    /**
     * 忽略指定的文件
     * @param $file
     * @return bool
     */
    private function shouldIgnore($file)
    {
        return preg_match('/(^_|\/_)/', $file->getRelativePathname()) === 1;
    }

    /**
     * 编译生成静态文件
     * @param $file
     * @param $dest
     * @param $config
     */
    private function buildFile($file, $dest, $config)
    {
        $file = $this->handle($file, $config);
        $directory = $this->getDirectory($file);
        $this->prepareDirectory("{$dest}/{$directory}");
        $this->files->put("{$dest}/{$this->getRelativePathname($file)}", $file->contents());
    }

    private function handle($file, $config)
    {
        return $this->getHandler($file)->handle($file, $config);
    }

    private function getDirectory($file)
    {
        if ($this->options['pretty']) {
            return $this->getPrettyDirectory($file);
        }

        return $file->relativePath();
    }

    private function getPrettyDirectory($file)
    {
        if ($file->extension() === 'html' && $file->name() !== 'index.html') {
            return "{$file->relativePath()}/{$file->basename()}";
        }

        return $file->relativePath();
    }

    private function getRelativePathname($file)
    {
        if ($this->options['pretty']) {
            return $this->getPrettyRelativePathname($file);
        }

        return $file->relativePathname();
    }

    private function getPrettyRelativePathname($file)
    {
        if ($file->extension() === 'html' && $file->name() !== 'index.html') {
            return $this->getPrettyDirectory($file) . '/index.html';
        }

        return $file->relativePathname();
    }

    private function getHandler($file)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($file)) {
                return $handler;
            }
        }
    }
}