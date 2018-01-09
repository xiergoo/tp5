<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
namespace think;
use think\exception\ClassNotFoundException;
use think\exception\ValidateException;
/**
 * 加密解密类
 */
class Crypt {
    protected static $prefix = '';
    private static $handler    =   '';
    
    /**
     * Crypt初始化
     * @param array $config
     * @return void
     * @throws \think\Exception
     */
    public static function init(array $config = [])
    {
        if (empty($config)) {
            $config = Config::get('crypt');
        }
        // 记录初始化信息
        App::$debug && Log::record('[ CRYPT ] INIT ' . var_export($config, true), 'info');
        
        if (isset($config['prefix']) && ('' === self::$prefix || null === self::$prefix)) {
            self::$prefix = $config['prefix'];
        }
        if (!empty($config['type'])) {
            // 读取session驱动
            $class = false !== strpos($config['type'], '\\') ? $config['type'] : '\\think\\crypt\\driver\\' . ucwords($config['type']);

            // 检查驱动类
            if (!class_exists($class)) {
                throw new ClassNotFoundException('error crypt handler:' . $class, $class);
            }
            self::$handler  =    $class;
        }else{
            throw new ValidateException('config type miss:' . var_export($config, true));
        }
    }

    /**
     * 加密字符串
     * @param string $str 字符串
     * @param string $key 加密key
     * @param integer $expire 有效期（秒） 0 为永久有效
     * @return string
     */
    public static function encrypt($data,$key,$expire=0){
        if(empty(self::$handler)){
            self::init();
        }
        $class  =   self::$handler; 
        return $class::encrypt($data,self::$prefix.$key,$expire);
    }

    /**
     * 解密字符串
     * @param string $str 字符串
     * @param string $key 加密key
     * @return string
     */
    public static function decrypt($data,$key){
        if(empty(self::$handler)){
            self::init();
        }
        $class  =   self::$handler;         
        return $class::decrypt($data,self::$prefix.$key);
    }
}