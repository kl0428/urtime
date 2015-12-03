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
        if(isset($type) && isset($mobile)){// $type =='register','forget',
            $num = $this->getrandstr();
            $cache = Yii::app()->cache;
            $cache->hset($mobile,$type,$num);

            $sms = new Sms();
            $result = $sms->send($mobile, '您好，Urtime提示您,您的验证码是:'.$num,true);
            var_dump($result);
            exit;
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

        //++++++测试start+++++//
        $rands = '654321';
        //++++++测试end+++++++//
        return $rands;
    }

    /**
     * 请求远端post提取返回数据
     * $url 远端请求地址
     * $data 需要post的数据以数组方式
     */
    public function doPost($url,$data=array(),$json=false){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if($json!=false) curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: '.strlen($data)));
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}