<?php
namespace app\admin\logic;
use think\Model;
use app\admin\logic\User;
Class Score extends Model{
    const TYPE_RECHARGE=1;
    const TYPE_ORDER=2;
    const TYPE_DAKA=3;
    const TYPE_LUCK=4;
    const TYPE_IN=5;
    const TYPE_OUT=6;
    const TYPE_SEND=7;
    
    const DAKA_SCORE=10;
    
    protected $fields=['id','uid','type','params','score','mark','create_time'];
    
    public function types($type=''){
        $types = [
            self::TYPE_RECHARGE=>'TYPE_RECHARGE',
            self::TYPE_ORDER=>'TYPE_ORDER',
            self::TYPE_DAKA=>'TYPE_DAKA',
            self::TYPE_LUCK=>'',
            self::TYPE_IN=>'',
            self::TYPE_OUT=>'',
            self::TYPE_SEND=>'',
        ];
        if($type){
            if(array_key_exists($type,$types)){
                return $types[$type];
            }
            return '';
        }
        return $types;
    }
    
    /**
     * Summary of daka
     * @param array $score ['uid']
     * @return mixed
     */
    public function daka($score){
        $uid=isset($score['uid'])?intval($score['uid']):0;
        if($uid<1){
            $this->error='无效的uid';
            return false;
        }
        $logicUser = new User();
        if(!$logicUser->checkLimits($uid,User::LIMIT_DAKA)){
            $this->error='您不能这么做';
            return false;
        }
        return $this->changeScore($uid,self::TYPE_DAKA,self::DAKA_SCORE,'签到',0);
    }
    
    /**
     * Summary of recharge
     * @param array $params ['uid','amount']
     * @return mixed
     */
    public function recharge($params){
        $uid=$params['uid'];
        if($uid<1){
            $this->error='无效的uid';
            return false;
        }
        $logicUser = new User();
        if(!$logicUser->checkLimits($uid,User::LIMIT_SCORE_RECHARGE)){
            $this->error='您不能这么做';
            return false;
        }
        $amount = $params['amount'];
        if($amount<10){
            $this->error='参数不能小于10';
            return false;
        }
        return $this->changeScore($uid,self::TYPE_RECHARGE,$amount*100,'充值',0);        
    }
    
    public function order($score){
        $uid=$score['uid'];
        if($uid<1){
            $this->error='无效的uid';
            return false;
        }
        if($score['score']==0){
            $this->error='无效的积分值';
            return false;
        }
        if($score['order_id']<1){
            $this->error='无效的订单id';
            return false;
        }        
        if($score['score']>0){
            $score['score']=0-$score['score'];
        }
        return $this->changeScore($uid,self::TYPE_ORDER,intval($score['score']),'下单',$score['order_id'],false);        
    }
    
    private function changeScore($uid,$type,$score,$mark,$params=0,$autoTrans=true){
        if($autoTrans===true){
            \think\Db::transaction(function(){
                $data['uid']=$uid;
                $data['type']=$type;
                $data['params']=$params;
                $data['score']=$score;
                $data['mark']=$mark;
                $data['ctime']=time();
                $result = \think\Db::name('score')->insert($data);
                if($result){
                    $logicUser = \think\Loader::model('User','logic');
                    $result = $logicUser->exchangeSocre($uid,$score);
                    if($result){
                        return true;
                    }else{
                        $this->error='修改用户积分失败';
                        return false;
                    }
                }else{
                    $this->error='保存积分明细失败';
                    return false;
                }
            });
        }else{
            $data['uid']=$uid;
            $data['type']=$type;
            $data['params']=$params;
            $data['score']=$score;
            $data['mark']=$mark;
            $data['ctime']=time();
            $result = \think\Db::name('score')->insert($data);
            if($result){
                $logicUser = \think\Loader::model('User','logic');
                $result = $logicUser->exchangeSocre($uid,$score);
                if($result){
                    return true;
                }else{
                    $this->error='修改用户积分失败';
                    return false;
                }
            }else{
                $this->error='保存积分明细失败';
                return false;
            }
        }
    }
    /**
     * Summary of score_exc
     * @param array $score ['uid','to_uid','score']
     * @return mixed
     */
    public function scoreExc($score){
        $uid=$score['uid'];
        if($uid<1){
            $this->error='无效的uid';
            return false;
        }
        $logicUser = new User();
        if(!$logicUser->checkLimits($uid,User::LIMIT_SCORE_OUT)){
            $this->error='您不能这么做';
            return false;
        }
        $to_uid = $score['to_uid'];
        if($to_uid<1){            
            $this->error='无效的目标uid';
            return false;
        }
        if(!$logicUser->checkLimits($to_uid,User::LIMIT_SCORE_IN)){
            $this->error='您不能这么做.';
            return false;
        }
        $score['score'] = abs($score['score']);
        if($score['score']<10000){
            $this->error='不能少于10000分';
            return false;
        }        
        $scoreValue = $this->getScore($uid);
        if($scoreValue<$score['score']){
            $this->error='您的积分不足';
            return false;          
        }
        \think\Db::transaction(function(){
            $data=[];
            $data['uid']=$uid;
            $data['type']=self::TYPE_OUT;
            $data['params']=$to_uid;
            $data['score']=0-$score['score'];
            $data['mark']='转出';
            $data['ctime']=time();
            $result = \think\Db::name('score')->insert($data);
            if($result){
                $data=[];
                $data['uid']=$to_uid;
                $data['type']=self::TYPE_OUT;
                $data['params']=$uid;
                $data['score']=$score['score'];
                $data['mark']='转入';
                $data['ctime']=time();
                $result = \think\Db::name('score')->insert($data);
            }
            if($result){
                return true;
            }else{
                return false;
            }
         });
    }
    
    public function getScore($uid){        
        $score=0;
        if($uid>0){
            $score = db('score')->where(['uid'=>$uid])->sum('score');
        }
        return intval($score);
    }        
}
?>
