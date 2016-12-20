<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/20
 * Time: 13:34
 * Desc:
 */

namespace App\Contracts;

use Illuminate\Http\Request;

interface CompliteInterface
{

    public function publish(Request $request);

}