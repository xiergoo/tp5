<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 得到一串随机组成的字符串
 * @param number $length
 * @return string
 */
function getRandomChar($length = 6){
    $chars = array(
        'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
        'A','B','N','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
        '1','2','3','4','5','6','7','8','9','0'
    );
    $count = count($chars)-1;
    $tmpChars = '';
    for ($i = 0;$i<$length;$i++){
        $tmpChars .= $chars[mt_rand(0, $count)];
    }
    return $tmpChars;
}

/**
 * 获取不重复字符串
 * @param mixed $len 
 * @return mixed
 */
function getUniqueCode($len = 8)
{
    $len = max(8, $len);
    $len = min(16, $len);
    $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $rand = $code[rand(0, 25)]
        . strtoupper(dechex(date('m')))
        . date('d') . substr(time(), -5)
        . substr(microtime(), 2, 5)
        . sprintf('%03d', rand(0, 999));
    $a = md5($rand, true) . md5(strrev($rand), true);
    $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV';
    $d = '';
    for (
        $f = 0;
        $f < $len;
        $g = ord($a[$f]),
        $d .= $s[($g ^ ord($a[$f + 8])) - $g & 0x1F],
        $f++
    ) ;
    return $d;
}