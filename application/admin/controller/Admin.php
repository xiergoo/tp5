<?php
namespace app\admin\controller;
class Admin extends Base
{    
    public function index()
    {
        $this->assign('headtitle','gex');
        return $this->fetch('index/index');
    }
    
    public function add(){
        $this->assign('headtitle','gex');
        return $this->fetch('index/index');
    
    }
}
