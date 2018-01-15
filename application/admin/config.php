<?php
return [
    'url_route_on'=>false,
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
    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

    'log'                    => [
        // 日志记录方式，内置 file socket 支持扩展
        'type'  => 'File',
        // 日志保存目录
        'path'  => LOG_PATH.'admin'.DS,
        // 日志记录级别
        'level' => [],
    ],
];
