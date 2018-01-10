<?php
namespace app\admin\logic;
use think\Model;
class Admin extends Model
{
    protected $readonly = ['id','create_time'];
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
        $adminModel = \app\admin\model\Admin::get(['username'=>$username]);        
        if($adminModel->id<=0){            
            $this->error='帐号不存在';
            return false;
        }        
        if(getHashPassword($password,$adminModel->salt)==$adminModel->password){
            if($adminModel->status!=1){
                $this->error='帐号已禁用';
                return false;
            }
            $adminModel->login_ip=request()->ip();
            $adminModel->login_time=time();
            $adminModel->login_times=intval($adminModel->login_times)+1;
            $adminModel->save();
            return $adminModel->visible(['id','username','displayname','role_id'])->toArray();
        }else{
            $this->error='密码错误';
            return false;
        }
        
    }
    
    public function checkVerifyCode($verifycode){
        return true;
    }
}