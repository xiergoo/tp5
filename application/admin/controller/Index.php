<?php
namespace app\admin\controller;
class Index extends Base
{    
    public function index()
    {
        $this->assign('headtitle','gex');
        return $this->fetch('index/index');
    }
}
