<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2017/4/19
 * Time: 10:57
 * Desc:
 */

namespace App\Console\Commands\Generate;

use App\Library\Generate\BaseCommand;
use Illuminate\Support\Collection;
use App\Console\Commands\Generate\Traits\Generate;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RollbackGeneratorCommand extends BaseCommand
{
    use Generate;

    /**
     * The name of command.
     *
     * @var string
     */
    protected $name = 'jiyis:rollback {name} {--module=}';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Rollback all api directory.';


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
            /* $this->rollback();
             $this->info('Rollback all api directory successfully!');
             return false;*/
        }
        //如果指定了模块
        if ($this->option('module')) {
            addModulePathForGenerator(studly_case($this->option('module')));
        }

        $module = trim($this->argument('name'));

        $module = studly_case(trim($module));
        $this->rollback($module);

        $this->info('Rollback api directory successfully!');
    }

    protected function rollback($module = '')
    {
        $this->combine($module);

        foreach ($this->generators as $generator) {
            $generator->rollback();
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
                'module',
                'm',
                InputOption::VALUE_OPTIONAL,
                'Module path.',
                null
            ],
        ];
    }

}