<?php
namespace app\admin\controller;
use think\Controller;
class Base extends Controller
{
    protected $adminID=0;
    public function _initialize()
    {
        $adminInfo = $this->getLoginAdmin();
        if($adminInfo['id']<=0){
            $response = redirect('Common/login')->remember();            
            throw new \think\Exception\HttpResponseException($response);
        }
        //$this->checkRole();
        $this->assign('controller',$this->request->controller());
        $this->assign('action',$this->request->action());
        $this->assign('headtitle','');
        $this->assign('description','');
    }
    
    private $sessionKey='adminLogicLoginUser';
    protected function getLoginAdmin(){
        $data = session($this->sessionKey);
        if($data){
            $data=\think\Crypt::decrypt($data,$this->sessionKey);
        }
        return $data;
    }
}
