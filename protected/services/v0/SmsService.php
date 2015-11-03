<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-11-3
 * Time: 上午11:07
 */

class SmsService extends AppApiService
{
    //发短信
    public function sendSms($params = array())
    {
        //extract($params);
        $type = $params['type'];
        $mobile = $params['mobile'];
        if(isset($type) && $type =='register' && isset($mobile)){
            $num = $this->getrandstr();
            $cache = Yii::app()->cache;
            $cache->hset($mobile,$type,$num);
            $sms = new Sms();
            $result = $sms->sendSMS($mobile, '您好，Urtime提示您,您的验证码是:'.$num,'true');
            $result = $sms->execResult($result);
            if($result[1]==0){
               // echo '发送成功';
                $ret = $this->notice('OK', 0, '', $result);

            }else{
                //echo "发送失败{$result[1]}";
                $ret = $this->notice('ERR', 307, '', $result);
            }
        }else{
            $ret = $this->notice('ERR', 301, '', array('mobile'=>isset($mobile)?$mobile:0,'type'=>isset($type)?$type:''));
        }
        return $ret;
    }

    private function getrandstr(){
        $str='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $randStr = str_shuffle($str);//打乱字符串
        $rands= substr($randStr,0,6);//substr(string,start,length);返回字符串的一部分
        return $rands;
    }
}