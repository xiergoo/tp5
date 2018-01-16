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


/**
 * curl post方法请求
 * @param string $url 请求目标地址
 * @param array|string $data post数据
 * @return string 请求结果
 **/
function httpPost($url, $data) {
    $header = array (
        'Accept:*/*',
        'Accept-Charset:utf-8;q=0.7,*;q=0.3',
        'Accept-Encoding:gzip,deflate,sdch',
        'Accept-Language:zh-CN,zh;q=0.8',
        'Connection:keep-alive',
        'Host:' . '',
        'Origin:' . '',
        'Referer:' . '',
        'X-Requested-With:XMLHttpRequest'
    );
    $curl = curl_init (); // 启动一个curl会话
    curl_setopt ( $curl, CURLOPT_URL, $url ); // 要访问的地址
    curl_setopt ( $curl, CURLOPT_HTTPHEADER, http_build_query ( $header ) ); // 设置HTTP头字段的数组
    curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, 0 ); // 对认证证书来源的检查
    curl_setopt ( $curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:26.0) Gecko/20100101 Firefox/23.0'); // 模拟用户使用的浏览器
    curl_setopt ( $curl, CURLOPT_FOLLOWLOCATION, 1 ); // 使用自动跳转
    curl_setopt ( $curl, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer
    curl_setopt ( $curl, CURLOPT_POST, 1 ); // 发送一个常规的Post请求
    curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data ); // Post提交的数据包
    curl_setopt ( $curl, CURLOPT_COOKIE, '' ); // 读取储存的Cookie信息
    curl_setopt ( $curl, CURLOPT_TIMEOUT, 20 ); // 设置超时限制防止死循环
    curl_setopt ( $curl, CURLOPT_HEADER, 0 ); // 显示返回的Header区域内容
    curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 ); // 获取的信息以文件流的形式返回
    $result = curl_exec ( $curl ); // 执行一个curl会话
    curl_close ( $curl ); // 关闭curl
    return $result;
}

/**
 * curl get方法请求
 * @param $url
 * @param int $timeout
 * @return mixed
 */
function httpGet($url, $timeout=15){ // 模拟获取内容函数
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_HTTPGET, 1); // 发送一个常规的GET请求
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $result = curl_exec ( $curl ); // 执行一个curl会话
    curl_close ( $curl ); // 关闭curl
    return $result;
}