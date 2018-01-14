<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/18
 * Time: 17:55
 * Desc:
 */

namespace App\Library\Generate\Generators;


class RouteGenerator extends BaseGenerator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'route';


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
        return 'routes';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/../' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(),
                true) . '/' . 'api.php';
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
        $namespace = config('inno.controllers', 'Http\Controllers\Api\V1');
        $module    = $this->getName();

//        $routes = $this->generateRoute($module);

        return array_merge(parent::getReplacements(), [
            'version'              => config('api.version', 'v1'),
            'controller_namespace' => $namespace,
            'appname'              => $this->getAppNamespace(),
        ]);

    }

    public function generateRoute()
    {

        $stub = $this->combineRoutes();
        $apiroutes = $this->filesystem->get(base_path('routes/').'api.php');
        $apiroutes = preg_replace('/\}\);\s*$/', "\r\n".$stub."\r\n});", $apiroutes);

        return $apiroutes;
        //return str_replace("});\r\n});\r\n", $routes."\t});\r\n});\r\n", $apiroutes);

    }

    protected function combineRoutes()
    {
        $stub = $this->getStub();

        $tmp = '$api->get(\'$ROUTE$\',\'$CONTROLLER$Controller@index\');'.PHP_EOL."\t\t".'$api->get(\'$ROUTE$/count\',\'$CONTROLLER$Controller@count\');'.PHP_EOL."\t\t".'$api->get(\'$ROUTE$/{id}\',\'$CONTROLLER$Controller@show\')->where(\'id\', \'[0-9]+\');'.PHP_EOL."\t\t".'$api->post(\'$ROUTE$\',\'$CONTROLLER$Controller@store\');'.PHP_EOL."\t\t".'$api->put(\'$ROUTE$/{id}\',\'$CONTROLLER$Controller@update\')->where(\'id\', \'[0-9]+\');'.PHP_EOL."\t\t".'$api->delete(\'$ROUTE$/{id}\',\'$CONTROLLER$Controller@destroy\')->where(\'id\', \'[0-9]+\');'.PHP_EOL."\t\t".'$api->delete(\'$ROUTE$/batch\',\'$CONTROLLER$Controller@destroyAll\');'.PHP_EOL;

        $route      = str_plural(snake_case(trim($this->getName())));
        $controller = studly_case(trim($this->getName()));

        $routes    = str_replace('$ROUTE$', $route, $tmp);
        $routes    = str_replace('$CONTROLLER$', $controller, $routes);

        $stub = str_replace('$ROUTES$', $routes, $stub);
        $stub = str_replace('$ROUTENAME$', $route, $stub);
        return $stub;
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
        $path = $this->getPath();
        if (!$this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0777, true, true);
        }

        return $this->filesystem->put($path, $this->generateRoute());
    }

    public function rollback()
    {
        $this->setUp();

        $route      = str_plural(snake_case(trim($this->getName())));
        $apiroutes = $this->filesystem->get(base_path('routes/').'api.php');
        $apiroutes = preg_replace('/\s*\/\/'.$route.'\s+\$api->group\([\s\S]+?\}\);\s/', "", $apiroutes);

        $path = $this->getPath();
        return $this->filesystem->put($path,$apiroutes);

    }


}