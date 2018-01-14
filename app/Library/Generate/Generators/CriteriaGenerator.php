<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/18
 * Time: 18:25
 * Desc:
 */

namespace App\Library\Generate\Generators;


class CriteriaGenerator extends BaseGenerator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'criteria/criteria';

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
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'criteria';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getName() . 'Criteria.php';
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

}