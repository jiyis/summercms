<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;
use App\Library\Search\XunsearchEngine;

class XunsearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/xunsearch.php' => config_path('xunsearch.php'),
        ], 'config');
        resolve(EngineManager::class)->extend('xunsearch', function () {
            return new XunsearchEngine();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
