<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BuildLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建一个从编译目录到laravel目录的软连接';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (file_exists(base_path('build/action'))) {
            return $this->error('The "build/action" directory already exists.');
        }

        $this->laravel->make('files')->link(public_path(), base_path('build/action'));

        $this->info('The [build/action] directory has been linked.');
    }
}
