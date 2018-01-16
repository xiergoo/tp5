<?php
namespace app\admin\controller;
class Common extends Base
{    
    public function _initialize(){
        $adminInfo = $this->getLoginAdmin();
        $this->adminID=intval($adminInfo['id']);
    }
    
    public function login()
    {
        if($this->adminID>0){
            $this->redirect('Index/index');
        }
        if($this->request->isPost()){
            $username=$this->request->post('username','','trim');
            $password=$this->request->post('password','','trim');
            $logicAdmin = new \app\common\logic\AdminLogic();
            $adminInfo = $logicAdmin->login($username,$password,'1234');
            if(!$adminInfo){
                $this->error($logicAdmin->getError());
            }
            $this->setLoginAdmin($adminInfo);
            return redirect()->restore();
        }else{
            return $this->fetch();
        }
    }
    
    public function logout(){
        if($this->adminID>0){
            parent::setLoginAdmin(null);
        }
        $this->redirect('Common/login');
    }
}
