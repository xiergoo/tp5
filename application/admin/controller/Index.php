<?php
namespace app\admin\controller;
class Index extends Base
{    
    public function index()
    {        
        $this->assign('title','gex');
        return $this->fetch('index/index');
    }
    
    public function index2(){
        $this->assign('title','gex2');
        return $this->fetch('index/index');
    }
}
