<?php
namespace app\admin\controller;
use think\Controller;
class Base extends Controller
{
    protected $adminID=0;
    protected $adminInfo=null;
    public function _initialize()
    {
        $this->adminInfo = $this->getLoginAdmin();
        if($this->adminInfo['id']<=0){
            $response = redirect('Common/login')->remember();
            throw new \think\Exception\HttpResponseException($response);
        }
        $this->adminID=intval($this->adminInfo['id']);
        defined('ADMIN_ID') or define('ADMIN_ID',$this->adminID);
        if(!$this->checkRole()){
            $this->error('没有权限',url('Index/index'));
        }
        $this->assign('controller',$this->request->controller());
        $this->assign('action',$this->request->action());
        $this->assign('headtitle','');
        $this->assign('description','');
    }
    
    protected function checkRole($controller='',$action=''){
        if(!$controller){
            $controller=$this->request->controller();
        }
        if(!$action){
            $action=$this->request->action();
        }
        $menuInfo = \app\admin\model\Menu::get(['url'=>$controller.'/'.$action]);
        return validateMenu($this->adminInfo['role_id'],$menuInfo->id);
    }
        
    private $sessionKey='adminLogicLoginUser';
    protected function getLoginAdmin(){
        $data = session($this->sessionKey);
        if($data){
            $data=\think\Crypt::decrypt($data,$this->sessionKey);
            if($data){
                $data=json_decode($data,true);
            }
        }
        return $data;
    }
    protected function setLoginAdmin($adminInfo){
        if($adminInfo['id']>0){
            session($this->sessionKey, \think\Crypt::encrypt(json_encode($adminInfo),$this->sessionKey));
        }elseif($adminInfo===null){
            session($this->sessionKey,null);
        }
    }
}
