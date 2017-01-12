<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/24
 * Time: 11:11
 * Desc:
 */

namespace App\Presenter;


use App\Transformer\MatchTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class MatchPresenter extends FractalPresenter
{

    public function getTransformer()
    {
        return new MatchTransformer();
    }
}