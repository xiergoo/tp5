<?php
namespace app\common\logic;
Class UserLogic{
    const LIMIT_LOGIN=1;
    const LIMIT_DAKA=2;
    const LIMIT_ORDER=3;
    const LIMIT_SCORE_OUT=4;
    const LIMIT_SCORE_IN=5;
    const LIMIT_SCORE_RECHARGE=6;
    //7、8、9、10保留，暂未使用
    const MACH_MIN_UID=12000;
    const MACH_MAX_UID=13000;
        
    public function Register($user){
        if(!isset($user['openid'])||!$user['openid']){
            $this->error='无效的openid';
            return false;
        }
        $openid=$user['openid'];
        $info = \think\Db::name('user')->where(['openid'=>$openid])->find();
        if($info && $info['id']>0){
            $this->error='用户已存在';
            return false;
        }
        $data = array (
            'openid'=>$openid,
			'nickname' => isset($user['nickname'])?$user['nickname']:'',
			'headimgurl' => isset($user['headimgurl'])?trim($user['headimgurl'],'0'):'',
			'gender' => isset($user['sex'])?($user['sex']==1?1:($user['sex']==2?2:0)):0,
			'subscribe' => isset($user ['subscribe'])?intval ( $user ['subscribe'] ):0,
			'subscribetime' => isset($user ['subscribe_time'])?intval ( $user ['subscribe_time'] ):0,
            'ivt_uid'=>isset($user['ivt_uid'])?intval($user['ivt_uid']):0,
            'limits'=>'1111110000',
			'create_time' => time()
		);
        return \think\Db::name('user')->insert($data);
    }    
    
    public function checkLimits($userID,$limit=UserLogic::LIMIT_LOGIN){
        $info = db('user')->where(['id'=>$userID])->cache(false)->find();
        if(!$info){
            return false;
        }
        return substr($info['limits'],$limit-1,1)==1;
    }
    
    public function limits($limit=''){
        $limits = [
            self::LIMIT_LOGIN=>'登录',
            self::LIMIT_DAKA=>'打卡',
            self::LIMIT_ORDER=>'下单',
            self::LIMIT_SCORE_OUT=>'转出',
            self::LIMIT_SCORE_IN=>'转入',
            self::LIMIT_SCORE_RECHARGE=>'充值',
        ];
        if($limit){
            if(array_key_exists($limit,$limits)){
                return $limits[$limit];
            }
            return '';
        }
        return $limits;
    }
    
	public function setLoginUser($user){
        if($user['id']>0){
            setNcCookie('u_key',encrypt(serialize($user),md5('LoginUser')),86400,'',null);
        }
	}
    
    public function getLoginUser(){
        return unserialize(decrypt(cookie('u_key'),md5('LoginUser')));
    }
    
    public function getScore($userID){
        if($userID>0){
            $info = db('user')->where(['id'=>$userID])->find();
            if($info){
                return intval($info['score']);
            }
        }
        return 0;
    }
    
    public function exchangeSocre($userID,$score){
        return db('user')->where(['id'=>$userID])->setInc('score',$score);
    }    
}
?>
