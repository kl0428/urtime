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
            $result = $sms->send($mobile, '【Urtime】您的注册验证码是：'.$num.'.请完成注册',true);
            $res = $sms->execResult($result);

            if($res[1]==0){
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

    public function send($mobile,$msg,$needstatus = 'false',$product = '',$extno = ''){
        $postArr = array(
            'account'       =>'jiekou-clcs-08',//Yii::app()->params['chuanglan']['api_account'],
            'pswd'          =>'Txb654321',//Yii::app()->params['chuanglan']['api_password'],
            'msg'           =>$msg,
            'mobile'        => $mobile,
            'needstatus'    =>$needstatus,
            // 'product'       =>$product,
            //'extno'         =>$extno,
        );
       //$snoopy = new Snoopy();
       //  $result = $snoopy->submit(Yii::app()->params['chuanglan']['api_send_url'],$postArr);
        //$result = $snoopy->submitlinks(Yii::app()->params['chuanglan']['api_send_url'],$postArr);
        //$result = $this->curlPost("http://222.73.117.158/msg/HttpBatchSendSM",$postArr);
        $result = $this->doPost("http://222.73.117.158/msg/HttpBatchSendSM",$postArr);
        return $result;
    }

    /**
     * 请求远端post提取返回数据
     * $url 远端请求地址
     * $data 需要post的数据以数组方式
     */
    public function doPost($url,$data=array(),$json=false){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
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

    /**
     * 请求远端get提取返回数据
     * $url 远端请求地址
     * $data 需要get的数据以数组方式
     */
    public function doGet($url,$data=false){
        if(is_array($data)){
            foreach($data AS $k=>$v){
                $grr[]=$k.'='.$v;
            }
            $txt = implode($grr,'&');
        }else{
            $txt = $data;
        }
        $target = $txt ? $url.'?'.$txt : $url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $target); // 要访问的地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}