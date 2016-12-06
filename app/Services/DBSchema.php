<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 2016/12/6
 * Time: 15:23
 * Desc:
 */

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use PDO;

class DBSchema
{
    public static function tables()
    {
        $driver = DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME);

        switch ($driver) {
            case 'sqlite':
                $query = "SELECT name FROM sqlite_master WHERE type='table' UNION ALL SELECT name FROM sqlite_temp_master WHERE type='table'";
                break;

            case 'mysql':
                $query = 'SHOW TABLES';
                break;

            case 'pgsql':
                $query = "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public'";
                break;

            default:
                throw new Exception("Voyager: Database driver [$driver] is not supported");
        }
        return array_filter(DB::select($query),function($value){
            return str_contains('_cms_',current($value));
        });
    }
}