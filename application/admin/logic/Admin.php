<?php
namespace app\admin\logic;
use think\Model;
class Admin extends Model
{
    public function login($username,$password,$verifycode){
        $data = [
            'username'=>$username,
            'password'=>$password,
            'verifycode'=>$verifycode
        ];
        $validate = \think\Loader::validate('Admin');
        if(!$validate->check($data,[],'login')){
            $this->error=$validate->getError();
            return false;
        }
        if(!$this->checkVerifyCode($verifycode)){
            $this->error='验证码错误';
            return false;
        }
    }
    
    public function checkVerifyCode($verifycode){
        return false;
    }
}