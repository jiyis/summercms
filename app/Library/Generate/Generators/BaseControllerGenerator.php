<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/18
 * Time: 18:22
 * Desc:
 */

namespace App\Library\Generate\Generators;


class BaseControllerGenerator extends BaseGenerator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'controller/base_controller';

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode());
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'controllers';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(),
                true) . '/' . 'BaseController.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('inno.generator.basePath', app_path());
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(parent::getReplacements(), [

        ]);
    }

}