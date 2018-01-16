<?php
namespace app\common\logic;
Class GdpLogic{
    const PSTATUS_OFFLINE=0;
    const PSTATUS_ONLINE=1;
    const PSTATUS_WAIT=2;
    const PSTATUS_FINISH=3;    
    const PPROTECTED_TIME=120;
    const OSCORE_MIN=1000;
    const OSCORE_MAX=10000;
    
    const TSTATUS_ENABLE=1;
    
    public function listsing($page=1){
        $typeCacheKey='listsingtype';
        $listType = cache($typeCacheKey);
        if(!$listType){
            $listType = db('gdp_type')->where(['enable'=>self::TSTATUS_ENABLE])->select();
            cache($typeCacheKey,$listType);
        }
        foreach ($listType as $type)
        {
        	$this->newPeroid($type['id']);
        }
        $where=[];
        $where['jtime']=['between',[DapanLogic::beforeTime()+1,DapanLogic::afterTime()]];
        $where['pstatus']=self::PSTATUS_ONLINE;
        return db('gdp_period')->where($where)->page($page)->cache(true,3)->select();
    }
    
    public function newPeroid($typeID){
        $typeInfo = db('gdp_type')->where(['id'=>$typeID])->cache(true,60)->find();
        if($typeInfo['id'] && $typeInfo['enable']==self::TSTATUS_ENABLE){
            $where['type_id']=$typeID;
            $where['jtime']=['between',[DapanLogic::beforeTime()+1,DapanLogic::afterTime()]];
            $where['pstatus']=self::PSTATUS_ONLINE;
            $curPeroid = db('gdp_period')->where($where)->cache(true,30)->find();
            if(!$curPeroid){
                $beforePeriod =db('gdp_period')->where(['type_id'=>$typeID])->order('pno','desc')->find();
                $data['type_id']=$typeID;
                $data['pno']=max(100,intval($beforePeriod['pno'])+1);
                $data['pstatus']=self::PSTATUS_ONLINE;
                $data['jtime']=DapanLogic::afterTime();
                $data['dpnum']=0;
                $data['jnum']=0;
                $data['inscore']=0;
                $data['outscore']=0;
                $data['ctime']=time();
                return db('gdp_period')->insert($data);
            }            
        }
        return false;
    }
    
    
    public function listUserOrder($uid,$is_right,$page=1){
        $where['uid']=$uid;
        if($is_right){
            $where['is_right']=1;
        }
        return db('gdp_order')->where($where)->order('id','desc')->page($page)->select();
    }
    
    public function listPeriodOrder($pid,$is_right,$page=1){
        $where['pid']=$pid;
        if($is_right){
            $where['is_right']=1;
        }
        return db('gdp_order')->where($where)->order('id','desc')->page($page)->select();
    }
}
?>
