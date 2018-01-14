<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/18
 * Time: 18:22
 * Desc:
 */

namespace App\Library\Generate\Generators;


class TransformerGenerator extends BaseGenerator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'transformer/transformer';

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
        return 'transformers';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getName() . 'Transformer.php';
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
        $modelGenerator = new ModelGenerator([
            'name' => $this->name
        ]);
        $model = $modelGenerator->getRootNamespace() . '\\' . $modelGenerator->getName();
        $model = str_replace([
            "\\",
            '/'
        ], '\\', $model);

        return array_merge(parent::getReplacements(), [
            'model' => $model
        ]);
    }

}