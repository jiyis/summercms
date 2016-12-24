<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/24
 * Time: 11:11
 * Desc:
 */

namespace App\Presenter;


use App\Transformer\PageTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class PagePresenter extends FractalPresenter
{

    public function getTransformer()
    {
        return new PageTransformer();
    }
}