<?php
namespace app\admin\controller;
class Role extends Base
{    
    public function index()
    {
        $this->assign('headtitle','角色列表');
        return $this->fetch('index/index');
    }
    
    public function add(){
        $this->assign('headtitle','添加角色');
        return $this->fetch('index/index');
    
    }
}
