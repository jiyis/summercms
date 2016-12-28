<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class GenerateModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'generate:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '新建数据表的时候生成Model模型';

    protected $type = 'Model';


    /**
     * Build the model class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $table = $this->option('table')? : str_plural(strtolower($this->getNameInput()));

        return $this->replaceNamespace($stub, $name)->replaceTable($stub, $table)->replaceClass($stub, $name);
    }

    /**
     * Replace the table for the given stub.
     *
     * @param  string  $stub
     * @param  string  $table
     * @return $this
     */
    protected function replaceTable(&$stub, $table)
    {

        $stub = str_replace('DummyTable', $table, $stub);

        return $this;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('resources/stub/').'model.stub';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['table', null, InputOption::VALUE_OPTIONAL, 'The table name.', null],
            ['fillable', null, InputOption::VALUE_NONE, 'The fillable columns.', null]
        ];
    }
}
