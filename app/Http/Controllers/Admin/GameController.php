<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\CommonServices;
use Breadcrumbs, Toastr;

class GameController extends BaseController
{

    //private $repository;

    public function __construct()
    {
        parent::__construct();

        Breadcrumbs::register('admin-game', function ($breadcrumbs) {
            $breadcrumbs->parent('控制台');
            $breadcrumbs->push('赛事管理', route('admin.game.index'));
        });
        //$this->repository = $repository;
        view()->share('models',CommonServices::getModels());
        view()->share('layouts',CommonServices::getLayouts());

    }
    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Breadcrumbs::register('admin-game-index', function ($breadcrumbs) {
            $breadcrumbs->parent('admin-game');
            $breadcrumbs->push('赛事列表', route('admin.game.index'));
        });
        //$games = $this->repository->all();
        return view('admin.game.index', compact('games'));
    }

    /**
     * Show the application 控制台.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Breadcrumbs::register('admin-game-edit', function ($breadcrumbs) use ($id) {
            $breadcrumbs->parent('admin-game');
            $breadcrumbs->push('编辑赛事', route('admin.game.edit', ['id' => $id]));
        });
        //$games = $this->repository->all();
        return view('admin.game.edit', compact('games'));
    }

}