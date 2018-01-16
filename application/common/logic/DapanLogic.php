<?php
namespace app\common\logic;
Class DapanLogic{
	public static function value(){
        try
        {
            $key='dp_value';        
            $value = 0;
            $value = cache($key);
            if($value && $value>0){
                return $value;
            }
            $arr=[];
            $content = httpGet('http://hq.sinajs.cn/list=s_sh000001');
            if($content){
                $arr=explode(',',$content);
                $value=$arr[1];
            }
            $value = round($value,2);
            if($value>1000){
                cache($key,$value,3);
            }
            return $value;  
        }
        catch (Exception $exception)
        {
            return 0;
        }        
    }
    
    public static function beforeTime($time=0){
        $beforeTime=0;
        if($time<=0){
            $time = time();
        }
        $week=date('w',$time);
        if($week==6){
            $beforeTime=mktime(15,0,0,date('n',$time),date('j',$time)-1);
        }elseif($week==0){
            $beforeTime=mktime(15,0,0,date('n',$time),date('j',$time)-2);
        }else{
            $h=date('H',$time);
            if($h>=15){
                $beforeTime=mktime(15,0,0,date('n',$time),date('j',$time));
            }else{
                if($week==1){
                    $beforeTime=mktime(15,0,0,date('n',$time),date('j',$time)-3);
                }else{
                    $beforeTime=mktime(15,0,0,date('n',$time),date('j',$time)-1);
                }
            }
        }
        return $beforeTime;
    }
    
    public static function afterTime($time=0){
        $afterTime=0;
        if($time<=0){
            $time = time();
        }
        $week=date('w',$time);
        if($week==6){
            $afterTime=mktime(15,0,0,date('n',$time),date('j',$time)+2);
        }elseif($week==0){
            $afterTime=mktime(15,0,0,date('n',$time),date('j',$time)+1);
        }else{
            $h=date('H',$time);
            if($h>=15){
                if($week==5){
                    $afterTime=mktime(15,0,0,date('n',$time),date('j',$time)+3);
                }else{
                    $afterTime=mktime(15,0,0,date('n',$time),date('j',$time)+1);
                }
            }else{                
                $afterTime=mktime(15,0,0,date('n',$time),date('j',$time));
            }
        }
        return $afterTime;
    }
}
?>
