<?php
/**
 * Created by PhpStorm.
 * User: Gary.F.Dong
 * Date: 17-11-14
 * Time: 上午10:25
 * Desc:
 */

return [

    "guards" => [
        "admin" => "后台",
        "front" => "前台"
    ],

    /**
     * 项目的品类，写死到这边，后续扩展可以放到数据库
     */
    "category" => [
        1 => "工程",
        2 => "类工程",
        3 => "教育",
    ],

    /**
     * 项目的把握度
     */
    "power" => [
        10 =>  "10%",
        30 =>  "30%",
        50 =>  "50%",
        75 =>  "75%",
        100 =>  "100%",
    ],

    /**
     * 审核状态
     */
    "review_status" => [
        0 => "未通过",
        1 => "通过",
    ],

    /**
     * 上传图片或者文件保存的目录
     */
    'images'         => 'uploads/images/',
    'files'          => 'uploads/files/',

];