<?php
namespace app\admin\controller;
use think\Controller;
class Base extends Controller
{
    public function _initialize()
    {
        $this->assign('controller',$this->request->controller());
        $this->assign('action',$this->request->action());
    }
}
