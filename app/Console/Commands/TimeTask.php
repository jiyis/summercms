<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Swoole\Timer;

class TimeTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每天定时更新静态页面';

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
        //
        Timer::tick(1000,function (){
           echo "time out\n";
        });
    }
}
