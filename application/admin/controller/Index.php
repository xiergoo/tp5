<?php
namespace app\admin\controller;
class Index extends Base
{    
    public function index()
    {
        
        hash1();die;
        
        $admin = \think\Loader::model('Admin','logic');
        $result = $admin->login('adminn','admin23','134');
        if(!$result){
            dump($admin->getError());
        }
        die;
        $this->assign('headtitle','gex');
        return $this->fetch('index/index');
    }
}
