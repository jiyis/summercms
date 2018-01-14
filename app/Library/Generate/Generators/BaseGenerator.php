<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/18
 * Time: 17:56
 * Desc:
 */

namespace App\Library\Generate\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

abstract class BaseGenerator
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * The array of options.
     *
     * @var array
     */
    protected $options;

    /**
     * The shortname of stub.
     *
     * @var string
     */
    protected $stub;


    /**
     * Create new instance of this class.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->filesystem = new Filesystem;
        $this->options    = $options;
    }


    /**
     * Get the filesystem instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }


    /**
     * Set the filesystem instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return $this
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }


    /**
     * Get stub template for generated file.
     *
     * @return string
     */
    public function getStub()
    {
        $path = config('inno.generator.stubsOverridePath', __DIR__);

        if (!file_exists($path . '/Stubs/' . $this->stub . '.stub')) {
            $path = __DIR__;
        }

        return (new Stub($path . '/Stubs/' . $this->stub . '.stub', $this->getReplacements()))->render();
    }


    /**
     * Get template replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return [
            'class'          => $this->getClass(),
            'namespace'      => $this->getNamespace(),
            'appname'        => $this->getAppNamespace(),
            'plural'         => $this->getPluralName(),
            'root_namespace' => $this->getRootNamespace(),
        ];
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
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return base_path();
    }


    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . $this->getName() . '.php';
    }


    /**
     * Get name input.
     *
     * @return string
     */
    public function getName()
    {
        $name = str_singular($this->name);
        if (str_contains($this->name, '\\')) {
            $name = str_replace('\\', '/', $this->name);
        }
        if (str_contains($this->name, '/')) {
            $name = str_replace('/', '/', $this->name);
        }

        return Str::studly(str_replace(' ', '/', ucwords(str_replace('/', ' ', $name))));
    }


    /**
     * Get application namespace
     *
     * @return string
     */
    public function getAppNamespace()
    {
        return \Illuminate\Container\Container::getInstance()->getNamespace();
    }


    /**
     * Get class name.
     *
     * @return string
     */
    public function getClass()
    {
        return Str::studly(class_basename($this->getName()));
    }


    /**
     * Get paths of namespace.
     *
     * @return array
     */
    public function getSegments()
    {
        return explode('/', $this->getName());
    }


    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return config('inno.generator.rootNamespace', $this->getAppNamespace());
    }


    /**
     * Get class-specific output paths.
     *
     * @param $class
     *
     * @return string
     */
    public function getConfigGeneratorClassPath($class, $directoryPath = false)
    {
        switch ($class) {
            case ('models' === $class):
                $path = config('inno.generator.paths.models', 'Models');
                break;
            case ('repositories' === $class):
                $path = config('inno.generator.paths.repositories', 'Repositories');
                break;
            case ('repository_interface' === $class):
                $path = config('inno.generator.paths.repository_interface', 'Repositories/Contracts');
                break;
            case ('presenters' === $class):
                $path = config('inno.generator.paths.presenters', 'Presenters');
                break;
            case ('requests' === $class):
                $path = config('inno.generator.paths.requests', 'Http/Requests');
                break;
            case ('services' === $class):
                $path = config('inno.generator.paths.services', 'Services');
                break;
            case ('service_interface' === $class):
                $path = config('inno.generator.paths.service_interface', 'Services/Contracts');
                break;
            case ('transformers' === $class):
                $path = config('inno.generator.paths.transformers', 'Transformers');
                break;
            case ('validators' === $class):
                $path = config('inno.generator.paths.validators', 'Validators');
                break;
            case ('controllers' === $class):
                $path = config('inno.generator.paths.controllers', 'Http/Controllers/Api/V1');
                break;
            case ('criteria' === $class):
                $path = config('inno.generator.paths.criteria', 'Criteria');
                break;
            case ('routes' === $class):
                $path = config('inno.generator.paths.routes', 'routes');
                break;
            default:
                $path = '';
        }

        if ($directoryPath) {
            $path = str_replace('\\', '/', $path);
        } else {
            $path = str_replace('/', '\\', $path);
        }


        return $path;
    }


    abstract public function getPathConfigNode();


    /**
     * Get class namespace.
     *
     * @return string
     */
    public function getNamespace()
    {
        $segments = $this->getSegments();
        array_pop($segments);
        $rootNamespace = $this->getRootNamespace();
        if ($rootNamespace == false) {
            return null;
        }

        return 'namespace ' . rtrim($rootNamespace . '\\' . implode($segments, '\\'), '\\') . ';';
    }


    /**
     * Setup some hook.
     *
     * @return void
     */
    public function setUp()
    {
        //
    }

    /**
     * Setdown some hook.
     *
     * @return void
     */
    public function setDown()
    {
        //
    }


    /**
     * Run the generator.
     *
     * @return int
     * @throws \Exception
     */
    public function run()
    {
        $this->setUp();
        if ($this->filesystem->exists($path = $this->getPath()) && !$this->force) {
            throw new \Exception($path . ' has exists!');
        }
        if (!$this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0777, true, true);
        }

        return $this->filesystem->put($path, $this->getStub());
    }

    public function rollback()
    {
        $this->setDown();
        $path = $this->getPath();
        return $this->filesystem->delete($path);
    }

    /**
     * Get options.
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * Determinte whether the given key exist in options array.
     *
     * @param  string $key
     *
     * @return boolean
     */
    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }


    /**
     * Get value from options by given key.
     *
     * @param  string $key
     * @param  string|null $default
     *
     * @return string
     */
    public function getOption($key, $default = null)
    {
        if (!$this->hasOption($key)) {
            return $default;
        }

        return $this->options[$key] ?: $default;
    }


    /**
     * Helper method for "getOption".
     *
     * @param  string $key
     * @param  string|null $default
     *
     * @return string
     */
    public function option($key, $default = null)
    {
        return $this->getOption($key, $default);
    }


    /**
     * Handle call to __get method.
     *
     * @param  string $key
     *
     * @return string|mixed
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return $this->option($key);
    }
}