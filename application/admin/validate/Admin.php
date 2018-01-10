<?php
namespace app\admin\validate;
use think\Model;
use think\Validate;
class Admin extends Validate
{
    protected $rule = [
        'username|用户名'  =>  'require|min:5|max:20',
        'password|密码' =>  'require|min:6|max:20',
        'verifycode|验证码'=>'require|length:4',
        'salt'=>'require|length:4',
        'status'=>'require|in:1,2',
        'login_ip'=>'ip',
    ];
    
    protected $scene = [
        'add'   =>  ['username','password','salt','status'],
        'edit'  =>  ['username','password','salt','status'],
        'login' =>['username','password'],    
    ]; 
}