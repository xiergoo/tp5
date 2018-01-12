<?php
namespace app\admin\controller;
use app\admin\model\GdpType;
use app\admin\model\GdpPeriod;
class Gdp extends Base
{
    public function typeList()
    {
        $logicUser = \think\Loader::model('User','logic');
        $modelUser = $logicUser->Register(['openid'=>'82345openid']);
        
        $r = $logicUser->getScore(1);
        dump($r);
        $logicUser->exchangeSocre(1,-1);
        $r = $logicUser->getScore(1);
        dump($r);
        die;
        dump($modelUser);
        dump($modelUser->getError());
        
        //$list = GdpType::all();
        //dump($list);
    }
    public function typeSave()
    {
        $result='a';
        $modelGdpType = new GdpType();
        //$result = $modelGdpType->save(['name'=>'hos','enable'=>1,'mod'=>50,'times'=>40,'mark'=>'']);
        //$result = $modelGdpType->save(['name'=>'jo','enable'=>1,'mod'=>2,'times'=>1.6,'mark'=>'']);
        dump($result);
    }
    public function periodList(){
        $list = GdpPeriod::all();
        dump($list);
    }
}
