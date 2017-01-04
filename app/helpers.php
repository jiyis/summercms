<?php
/**
 * Created by PhpStorm.
 * User: Gary.P.Dong
 * Date: 2016/8/30
 * Time: 16:17
 */
function getClientIps()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                $ip_address = $ip;
            }
        } else {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
        $ip_address = $_SERVER['HTTP_FORWARDED'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}

function getModelTableName($table,$prefix = false)
{
    if($prefix) return env('DB_PREFIX').'cms_'.$table;
    return 'cms_'.$table;
}

function felixir($file, $buildDirectory = 'build')
{
    static $manifest = [];
    static $manifestPath;

    if (empty($manifest) || $manifestPath !== $buildDirectory) {
        $path = public_path($buildDirectory.'/rev-manifest.json');

        if (file_exists($path)) {
            $manifest = json_decode(file_get_contents($path), true);
            $manifestPath = $buildDirectory;
        }
    }

    if (isset($manifest[$file])) {
        return '/'.trim($buildDirectory.'/'.$manifest[$file], '/');
    }

    $unversioned = public_path($file);

    if (file_exists($unversioned)) {
        return '/'.trim($file, '/');
    }

    throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
}