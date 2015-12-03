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

            //$sms = new Sms();
            $result = $this->send($mobile, '您好，Urtime提示您,您的验证码是:'.$num,true);
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

    public function send($mobile,$msg,$needstatus = 'false',$product = '',$extno = ''){
        $postArr = array(
            'account'       =>'jiekou-clcs-08',//Yii::app()->params['chuanglan']['api_account'],
            'pswd'          =>'Txb654321',//Yii::app()->params['chuanglan']['api_password'],
            'msg'           =>$msg,
            'mobile'        => $mobile,
            'needstatus'    =>$needstatus,
            'product'       =>$product,
            'extno'         =>$extno,
        );
        $snoopy = new Snoopy();
        $result = $snoopy->submit('http://222.73.117.158/msg/index.jsp',$postArr);
        //$result = $this->curlPost("http://222.73.117.158/msg/index.jsp",$postArr);
        return $result;
    }
    private function curlPost($url,$postFields){
        $postFields = http_build_query($postFields);
       /* $ch = curl_init();
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postFields);
        $result = curl_exec($ch);*/
        //curl_close($ch);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        ob_start();
        curl_exec($ch);
        $result = ob_get_contents() ;
        ob_end_clean();
        //$result = curl_exec($ch);
        curl_close($ch);
        return $result;

    }
}