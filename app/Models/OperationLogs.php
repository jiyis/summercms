<?php
/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/8/30
 * Time: 15:07
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationLogs extends Model
{
    use SoftDeletes;

    public $table = 'operation_logs';

    public $fillable = [
        'controller',
        'action',
        'querystring',
        'userid',
        'username',
        'ip',
        'method',
    ];

}