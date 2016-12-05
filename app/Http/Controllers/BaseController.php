<?php
/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/6/29
 * Time: 8:54
 */

namespace App\Http\Controllers;

use InfyOm\Generator\Controller\AppBaseController;
use Auth;

class BaseController extends AppBaseController
{
    protected $user_id;
    protected $username;
    protected $student_id;

    public function __construct()
    {
        $this->middleware('auth');
        
    }

}