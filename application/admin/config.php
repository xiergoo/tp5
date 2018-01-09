<?php
return [
    //'url_route_on'=>false,
    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 20,
    ],
    'view_replace_str'  =>  [
    '__STATIC__'    =>'/static/',
    '__JS__'       =>'/static/assets/js/',
    '__CSS__'      => '/static/assets/css/',
    ],
    //加密配置
    'crypt'               => [
        'type'      => 'Think',
        'prefix'=>'tp5_admin',
    ],
];
