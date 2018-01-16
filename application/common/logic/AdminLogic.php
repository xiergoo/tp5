<?php
namespace app\common\logic;
use app\common\validate\AdminValidate;
class AdminLogic
{
    public function login($username,$password,$verifycode){
        $data = [
            'username'=>$username,
            'password'=>$password,
            'verifycode'=>$verifycode
        ];
        $validate = new AdminValidate();
        if(!$validate->check($data,[],'login')){
            $this->error=$validate->getError();
            return false;
        }
        if(!$this->checkVerifyCode($verifycode)){
            $this->error='验证码错误';
            return false;
        }
        $info = db('admin')->where(['username'=>$username])->find();
        if($info['id']<=0){            
            $this->error='帐号不存在';
            return false;
        }        
        if(getHashPassword($password,$info['salt'])==$info['password']){
            if($info['status']!=1){
                $this->error='帐号已禁用';
                return false;
            }
            $update['login_ip']=request()->ip();
            $update['login_time']=time();
            $update['login_times']=intval($info['login_times'])+1;
            \think\Db::name('admin')->where(['id'=>$info['id']])->update($update);
            return ['id'=>$info['id'],'username'=>$info['username'],'displayname'=>$info['displayname'],'role_id'=>$info['role_id']];
        }else{
            $this->error='密码错误';
            return false;
        }
        
    }
    
    public function checkVerifyCode($verifycode){
        return true;
    }
}