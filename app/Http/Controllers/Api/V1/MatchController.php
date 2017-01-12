<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/24
 * Time: 11:02
 * Desc:
 */

namespace App\Http\Controllers\Api\V1;


use App\Repository\MatchRepository;
use Illuminate\Http\Request;

class MatchController extends BaseController
{
    private $repository;

    public function __construct(MatchRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $this->repository->setPresenter("App\\Presenter\\MatchPresenter");
        $pages = $this->repository->paginate(6);
        $pages['gameCount'] = count($pages['data']);
        return $this->response->array($pages);
    }

}