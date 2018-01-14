<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/18
 * Time: 17:55
 * Desc:
 */

namespace App\Library\Generate\Generators;

use Prettus\Repository\Generators\Migrations\SchemaParser;

class RepositoryGenerator extends BaseGenerator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'repository/repository';


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
        return 'repositories';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(),
                true) . '/' . $this->getName() . 'Repository.php';
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
     * Gets controller name based on model
     *
     * @return string
     */
    public function getControllerName()
    {

        return ucfirst($this->getPluralName());
    }

    /**
     * Gets plural name based on model
     *
     * @return string
     */
    public function getPluralName()
    {

        return str_plural(lcfirst(ucwords($this->getClass())));
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
            'controller' => $this->getControllerName(),
            'plural'     => $this->getPluralName(),
            'singular'   => $this->getSingularName(),
            //'validator'  => $this->getValidator(),
            'repository' => $this->getRepository(),
            'appname'    => $this->getAppNamespace(),
            'model'      => $model,
        ]);

    }

    /**
     * Gets singular name based on model
     *
     * @return string
     */
    public function getSingularName()
    {
        return str_singular(lcfirst(ucwords($this->getClass())));
    }

    /**
     * Gets validator full class name
     *
     * @return string
     */
    public function getValidator()
    {
        $validatorGenerator = new ValidatorGenerator([
            'name' => $this->name,
        ]);

        $validator = $validatorGenerator->getRootNamespace() . '\\' . $validatorGenerator->getName();

        return 'use ' . str_replace([
                "\\",
                '/',
            ], '\\', $validator) . 'Validator;';
    }

    /**
     * Gets repository full class name
     *
     * @return string
     */
    public function getRepository()
    {
        $repositoryGenerator = new RepositoryInterfaceGenerator([
            'name' => $this->name,
        ]);

        $repository = $repositoryGenerator->getRootNamespace() . '\\' . $repositoryGenerator->getName();

        return 'use ' . str_replace([
                "\\",
                '/',
            ], '\\', $repository) . 'Repository;';
    }

    /**
     * Get the fillable attributes.
     *
     * @return string
     */
    public function getFillable()
    {
        if (!$this->fillable) {
            return '[]';
        }
        $results = '[' . PHP_EOL;

        foreach ($this->getSchemaParser()->toArray() as $column => $value) {
            $results .= "\t\t'{$column}'," . PHP_EOL;
        }

        return $results . "\t" . ']';
    }

    /**
     * Get schema parser.
     *
     * @return SchemaParser
     */
    public function getSchemaParser()
    {
        return new SchemaParser($this->fillable);
    }


}