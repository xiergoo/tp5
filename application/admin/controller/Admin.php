<?php
namespace app\admin\controller;
class Admin extends Base
{    
    public function index()
    {        
        $this->assign('title','gex');
        return $this->fetch('index/index');
    }
    
    public function add(){
        $this->assign('title','add');
        return $this->fetch('index/index');
    
    }
}
