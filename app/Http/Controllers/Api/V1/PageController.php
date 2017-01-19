<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/24
 * Time: 11:02
 * Desc:
 */

namespace App\Http\Controllers\Api\V1;


use App\Repository\PageRepository;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    private $repository;

    public function __construct(PageRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        /*$this->repository->setPresenter("App\\Presenter\\PagePresenter");
        $pages = $this->repository->all();
        return $this->response->array($pages);*/
    }

}