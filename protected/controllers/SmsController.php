<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-10-22
 * Time: 上午10:55
 */
class SmsController extends Controller
{
    public function actionIndex()
    {
        $clapi= new Sms();

       $result = $clapi->sendSMS('18368113211','你好,你的验证码是888888',true);//->sendSMS('18516590414', '您好，您的验证码是888888','true');

       $result = $clapi->execResult($result);

        if($result[1]==0){

            echo "发送成功";

        }else{

            echo "发送失败{$result[1]}";

        }

         var_dump($result);
       // $this->render('index');
    }
}