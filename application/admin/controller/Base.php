<?php
namespace app\admin\controller;
use think\Controller;
class Base extends Controller
{
    protected $adminID=0;
    public function _initialize()
    {
        
        //$this->checkRole();
        $this->assign('controller',$this->request->controller());
        $this->assign('action',$this->request->action());
        $this->assign('headtitle','');
        $this->assign('description','');
    }
}
