
<?php
//创蓝发送短信接口URL, 如无必要，该参数可不用修改

//$chuanglan_config['api_send_url'] = 'http://222.73.117.158/msg/HttpBatchSendSM';

//创蓝短信余额查询接口URL, 如无必要，该参数可不用修改

//$chuanglan_config['api_balance_query_url'] = 'http://222.73.117.158/msg/QueryBalance';

//创蓝账号 替换成你自己的账号

//$chuanglan_config['api_account'] = 'jiekou-clcs-07';

//创蓝密码 替换成你自己的密码

//$chuanglan_config['api_password'] = 'Clwh2009';
    class Sms{
        /**
         * 发短信接口
         * @param string $mobile
         * @param string $msg
         * @param string $needstatus
         * @param string $product
         * @param string $extno
        */
        public function sendSMS($mobile,$msg,$needstatus = 'false',$product = '',$extno = ''){
            $postArr = array(
                'account'       =>Yii::app()->params['chuanglan']['api_account'],
                'pswd'          =>Yii::app()->params['chuanglan']['api_password'],
                'msg'           =>$msg,
                'mobile'        => $mobile,
                'needstatus'    =>$needstatus,
                'product'       =>$product,
                'extno'         =>$extno,
            );
            $result = $this->curlPost(Yii::app()->params['chuanglan']['api_send_url'],$postArr);
            return $result;
        }


        public function queryBalance(){
            $postArr = array(
                'account'       =>Yii::app()->params['chuanglan']['api_account'],
                'pswd'          =>Yii::app()->params['chuanglan']['api_password'],
            );
            $result = $this->curlPost(Yii::app()->params['chuanglan']['api_balance_query_url'],$postArr);
            return $result;
        }

//        处理返回
        public function execResult($result)
        {
            $result = preg_split("/[,\r\n]/",$result);
            return $result;
        }

        private function curlPost($url,$postFields){
            $postFields = http_build_query($postFields);
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_HEADER,0);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$postFields);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;

        }

    //魔术获取
        public function __get($name){
            return $this->$name;
        }

    //魔术获取
    public function __set($name,$value){
        $this->$name = $value;
    }

    }

?>