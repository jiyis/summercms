<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/18
 * Time: 14:16
 * Desc:
 */

namespace App\Console\Commands\Generate;

use App\Library\Generate\BaseCommand;
use Illuminate\Support\Collection;
use App\Library\Generate\GeneratorsRouteGenerator;
use App\Console\Commands\Generate\Traits\Generate;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ApiGeneratorCommand extends BaseCommand
{

    use Generate;

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'jiyis:generate {class} {--module=}';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Generate all api directory.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Api';


    protected $generators;

    /**
     * APIGeneratorCommand constructor.
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        parent::__construct();
        $this->generators = $collection;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (empty($this->argument('name'))) {
            $this->error('Please input the class name, such as php artisan inno:init user,userinfo!');
            return false;
        }
        //如果指定了模块
        if ($this->option('module')) {
            addModulePathForGenerator(studly_case($this->option('module')));
        }

        $module = trim($this->argument('name'));

        $module = studly_case(trim($module));
        $this->generate($module);

        if ($this->option('route')) {
            try {
                $routeGenerator = new RouteGenerator([
                    'name'  => $this->argument('name'),
                    'force' => $this->option('force'),
                ]);
                $routeGenerator->run();
                $this->info("Routes created successfully.");
            } catch (FileExistsException $e) {
                $this->error($this->type . ' already exists!');

                return false;
            }
        }

        $this->info($this->type . ' created successfully.');
    }

    protected function generate($module)
    {

        $this->combine($module);
        //循环生成
        foreach ($this->generators as $generator) {
            $generator->run();
        }
    }

    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of class being generated.',
                null,
            ],
        ];
    }


    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'fillable',
                null,
                InputOption::VALUE_OPTIONAL,
                'The fillable attributes.',
                null,
            ],
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null,
            ],
            [
                'route',
                'r',
                InputOption::VALUE_NONE,
                'Force the creation if file already exists.',
                null,
            ],
            [
                'module',
                'm',
                InputOption::VALUE_OPTIONAL,
                'Module path.',
                null
            ],
        ];
    }


}