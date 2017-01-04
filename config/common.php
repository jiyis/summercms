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

];