<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/18
 * Time: 14:20
 * Desc:
 */

namespace App\Library\Generate;

use Illuminate\Console\Command;
use Inno\Core\Common\CommandData;
use App\Library\Generate\GeneratorsAPI\APIControllerGenerator;
use App\Library\Generate\GeneratorsAPI\APIRequestGenerator;
use Inno\Core\Utils\FileUtil;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BaseCommand extends Command
{
    /**
     * The command Data.
     *
     * @var CommandData
     */
    public $commandData;

    /**
     * @var Composer
     */
    public $composer;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->composer = app()['composer'];
    }

    public function handle()
    {
        $this->commandData->modelName = $this->argument('model');

        $this->commandData->initCommandData();
        $this->commandData->getFields();
    }

    public function generateCommonItems()
    {
        if (!$this->commandData->getOption('fromTable') and !$this->isSkip('migration')) {
            $migrationGenerator = new MigrationGenerator($this->commandData);
            $migrationGenerator->generate();
        }

        if (!$this->isSkip('model')) {
            $modelGenerator = new ModelGenerator($this->commandData);
            $modelGenerator->generate();
        }

        if (!$this->isSkip('repository')) {
            $repositoryGenerator = new RepositoryGenerator($this->commandData);
            $repositoryGenerator->generate();
        }
    }

    public function generateAPIItems()
    {
        if (!$this->isSkip('requests') and !$this->isSkip('api_requests')) {
            $requestGenerator = new APIRequestGenerator($this->commandData);
            $requestGenerator->generate();
        }

        if (!$this->isSkip('controllers') and !$this->isSkip('api_controller')) {
            $controllerGenerator = new APIControllerGenerator($this->commandData);
            $controllerGenerator->generate();
        }

        if (!$this->isSkip('routes') and !$this->isSkip('api_routes')) {
            $routesGenerator = new APIRoutesGenerator($this->commandData);
            $routesGenerator->generate();
        }

        if (!$this->isSkip('tests') and $this->commandData->getAddOn('tests')) {
            $repositoryTestGenerator = new RepositoryTestGenerator($this->commandData);
            $repositoryTestGenerator->generate();

            $testTraitGenerator = new TestTraitGenerator($this->commandData);
            $testTraitGenerator->generate();

            $apiTestGenerator = new APITestGenerator($this->commandData);
            $apiTestGenerator->generate();
        }
    }


    public function isSkip($skip)
    {
        if ($this->commandData->getOption('skip')) {
            return in_array($skip, (array)$this->commandData->getOption('skip'));
        }

        return false;
    }


    /**
     * @param $fileName
     * @param string $prompt
     *
     * @return bool
     */
    protected function confirmOverwrite($fileName, $prompt = '')
    {
        $prompt = (empty($prompt))
            ? $fileName . ' already exists. Do you want to overwrite it? [y|N]'
            : $prompt;

        return $this->confirm($prompt, false);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['fieldsFile', null, InputOption::VALUE_REQUIRED, 'Fields input as json file'],
            ['jsonFromGUI', null, InputOption::VALUE_REQUIRED, 'Direct Json string while using GUI interface'],
            ['tableName', null, InputOption::VALUE_REQUIRED, 'Table Name'],
            ['fromTable', null, InputOption::VALUE_NONE, 'Generate from existing table'],
            ['save', null, InputOption::VALUE_NONE, 'Save model schema to file'],
            ['primary', null, InputOption::VALUE_REQUIRED, 'Custom primary key'],
            ['prefix', null, InputOption::VALUE_REQUIRED, 'Prefix for all files'],
            ['paginate', null, InputOption::VALUE_REQUIRED, 'Pagination for index.blade.php'],
            [
                'skip',
                null,
                InputOption::VALUE_REQUIRED,
                'Skip Specific Items to Generate (migration,model,controllers,api_controller,scaffold_controller,repository,requests,api_requests,scaffold_requests,routes,api_routes,scaffold_routes,views,tests,menu,dump-autoload)',
            ],
            ['datatables', null, InputOption::VALUE_REQUIRED, 'Override datatables settings'],
            [
                'views',
                null,
                InputOption::VALUE_REQUIRED,
                'Specify only the views you want generated: index,create,edit,show',
            ],
            ['relations', null, InputOption::VALUE_NONE, 'Specify if you want to pass relationships for fields'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'Singular Model name'],
        ];
    }

}