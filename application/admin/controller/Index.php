<?php
namespace app\admin\controller;
class Index extends Base
{    
    public function index()
    {        
        $this->assign('title','gex');
        return $this->fetch('index/index');
    }
}
