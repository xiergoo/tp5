<?php
namespace app\admin\logic;
use think\Model;
use think\Crypt;
class Admin extends Model
{
    private $sessionKey='adminLogicLoginUser';
    public function getLoginAdmin(){
        $data = session($this->sessionKey);
        if($data){
            $data=Crypt::decrypt($data,$this->sessionKey);
        }
        return $data;
    }
    
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
            $this->error='ÑéÖ¤Âë´íÎó';
            return false;
        }
    }
    
    public function checkVerifyCode($verifycode){
        return false;
    }
}