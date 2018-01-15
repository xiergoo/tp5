<?php
namespace app\admin\controller;
class Gdp extends Base
{
    public function typeList()
    {        
        $page = intval($this->request->param['page']);
        $list =db('gdp_type')->where([])->paginate($page);
        dump($list);
    }
    public function typeSave()
    {
        //\think\Db::name('admin')->where(['id'=>$info['id']])->update($update);
    }
    public function periodList(){
        $page = intval($this->request->param['page']);
        $list =db('gdp_period')->where([])->paginate($page);
        dump($list);
    }
}
