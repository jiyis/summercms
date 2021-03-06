<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use App\Services\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $request = \Request::route();
            if (!empty($request)) {
                $current_route = $request->getName();
                $curRoutes     = explode('.', $current_route);
                $view->with('curRoutes', $curRoutes);
            }
        });
        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Voyager', Voyager::class);
            $loader->alias('Menu', \App\Models\Menu::class);
            $loader->alias('Category', \App\Models\Category::class);
            foreach (\Cache::get('real_facades', []) as $key => $item) {
                $loader->alias($key, $item);
            }
        });
    }
}
