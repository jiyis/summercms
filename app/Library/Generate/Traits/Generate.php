<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/19
 * Time: 12:41
 * Desc:
 */

namespace App\Console\Commands\Generate\Traits;

use App\Library\Generate\Generators\BaseControllerGenerator;
use App\Library\Generate\Generators\ControllerGenerator;
use App\Library\Generate\Generators\CriteriaGenerator;
use App\Library\Generate\Generators\ModelGenerator;
use App\Library\Generate\Generators\RepositoryGenerator;
use App\Library\Generate\Generators\RepositoryInterfaceGenerator;
use App\Library\Generate\Generators\CreateRequestGenerator;
use App\Library\Generate\Generators\ServiceGenerator;
use App\Library\Generate\Generators\ServiceInterfaceGenerator;
use App\Library\Generate\Generators\TransformerGenerator;
use App\Library\Generate\Generators\UpdateRequestGenerator;

trait Generate
{

    public function combine($module, $del = false)
    {
        //生成Model
        $modelGenerator = new ModelGenerator([
            'name'     => $module,
            'fillable' => $this->option('fillable'),
            'force'    => $this->option('force'),
        ]);

        $this->generators->push($modelGenerator);
        //生成repository的统一接口，只生成一次
        $repoName           = config('inno.generator.paths.repository_interface',
                'Repositories/Contracts') . '/RepositoryInterface.php';
        $repoInterGenerator = new RepositoryInterfaceGenerator([
            'name' => 'Repository',
        ]);
        if (!file_exists(app_path($repoName))) {
            $this->generators->push($repoInterGenerator);
        } else {
            if ($del) {
                $this->generators->push($repoInterGenerator);
            }
        }

        //生成 repository
        $repositoryGenerator = new RepositoryGenerator([
            'name'  => $module,
            'force' => $this->option('force'),
        ]);
        $this->generators->push($repositoryGenerator);

        //生成service 的统一接口，只生成一次
        $servName              = config('inno.generator.paths.service_interface',
                'Services/Contracts') . '/ServiceInterface.php';
        $serviceInterGenerator = new ServiceInterfaceGenerator([
            'name' => 'Service',
        ]);
        if (!file_exists(app_path($servName))) {
            $this->generators->push($serviceInterGenerator);
        } else {
            if ($del) {
                $this->generators->push($serviceInterGenerator);
            }
        }

        //生成service
        $serviceGenerator = new ServiceGenerator([
            'name'  => $module,
            'force' => $this->option('force'),
        ]);
        $this->generators->push($serviceGenerator);

        //生成transformer
        $transformerGenerator = new TransformerGenerator([
            'name' => $module,
        ]);
        $this->generators->push($transformerGenerator);

        //生成request
        $createRequestGenerator = new CreateRequestGenerator([
            'name'  => 'Create' . $module,
            'force' => $this->option('force'),
        ]);
        $updateRequestGenerator = new UpdateRequestGenerator([
            'name'  => 'Update' . $module,
            'force' => $this->option('force'),
        ]);
        $this->generators->push($createRequestGenerator);
        $this->generators->push($updateRequestGenerator);

        //生成criteria
        $criteriaGenerator = new CriteriaGenerator([
            'name'  => $module,
            'force' => $this->option('force'),
        ]);
        $this->generators->push($criteriaGenerator);

        //生成controller
        $controllerGenerator = new ControllerGenerator([
            'name'  => $module,
            'force' => $this->option('force'),
        ]);
        $this->generators->push($controllerGenerator);

        //生成basecontroller,只生成一次
        $baseControllerName = config('inno.generator.paths.controllers',
                'Http/Controllers/Api/V1') . '/BaseController.php';
        if (!file_exists(app_path($baseControllerName))) {
            $baseControllerGenerator = new BaseControllerGenerator([
                'name' => 'Base',
            ]);
            $this->generators->push($baseControllerGenerator);
        }

        return $this->generators;
    }

}