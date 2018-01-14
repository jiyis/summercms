<?php

namespace App\Http\Controllers\Admin;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        if (!Breadcrumbs::exists('控制台')) {
            Breadcrumbs::register('控制台', function ($breadcrumbs) {
                $breadcrumbs->push('控制台', route('admin.home'));
            });
        }

    }
}
