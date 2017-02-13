<?php


return [

    'driver'         => ['driver' => 'gd'],
    'posts_per_page' => 5,
    'upload'         => [
        'storage' => 'upload',
        'webpath' => 'uploads',
    ],
    'userpic'        => 'uploads/userpic',
    'images'         => '/uploads/images/',
    'files'          => '/uploads/files/',

    'regions'  => [
        1=>'欧洲',
        2=>'美洲',
        3=>'亚洲',
        4=>'其它'
    ],
    'games' => [
        1 => 'csgo',
        2 => 'LOL',
    ],
    'area' => "苏州（昆山）\r\n上海\r\n怀化\r\n聊城\r\n青岛\r\n扬州\r\n哈尔滨\r\n天津\r\n成都\r\n宁波\r\n广州\r\n泉州\r\n郑州",

    'task_update' => env('TASK_UPDATE', true),

];