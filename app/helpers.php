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
