<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\Traits\PublishManage;
use Illuminate\Console\Command;

class UpdateBuild extends Command
{
    use PublishManage;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:build';

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
        $this->publishAllPage();
        $this->publishAllContent();
        return date('Y-m-d H:i:s', time()) . 'update success';
    }
}
