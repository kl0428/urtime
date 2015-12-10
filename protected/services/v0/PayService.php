<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-11-19
 * Time: 上午8:50
 */

class PayService extends AppApiService
{
    public function pay($params = array())
    {
        Yii::import("application.extensions.Pingpp.*");
        // $pay = new application\extensions\Pingpp\Pingpp();
        //$input_data = array('channel'=>'alipay_wap','amount'=>'1');
        if (empty($params['channel']) || empty($params['amount'])) {
            echo 'channel or amount is empty';
            exit();
        }
        $channel = strtolower($params['channel']);
        $amount = $params['amount'];
        $orderNo = substr(md5(time()), 0, 12);
        $subject = $params['subject']?$params['subject']:"Urtime";
        $body = $params['body']?$params['body']:"你在Urtime购买了本产品";



//$extra 在使用某些渠道的时候，需要填入相应的参数，其它渠道则是 array() .具体见以下代码或者官网中的文档。其他渠道时可以传空值也可以不传。
        switch ($channel) {
            case 'alipay_wap':
                $extra = array(
                    'success_url' => 'http://www.baidu.com/success',
                    'cancel_url' => 'http://www.sohu.com/cancel'
                );
                break;
            case 'upmp_wap':
                $extra = array(
                    'result_url' => 'http://www.yourdomain.com/result?code='
                );
                break;
            case 'bfb_wap':
                $extra = array(
                    'result_url' => 'http://www.yourdomain.com/result?code=',
                    'bfb_login' => true
                );
                break;
            case 'upacp_wap':
                $extra = array(
                    'result_url' => 'http://www.yourdomain.com/result'
                );
                break;
            case 'wx_pub':
                $extra = array(
                    'open_id' => 'Openid'
                );
                break;
            case 'wx_pub_qr':
                $extra = array(
                    'product_id' => 'Productid'
                );
                break;
            case 'yeepay_wap':
                $extra = array(
                    'product_category' => '1',
                    'identity_id'=> 'your identity_id',
                    'identity_type' => 1,
                    'terminal_type' => 1,
                    'terminal_id'=>'your terminal_id',
                    'user_ua'=>'your user_ua',
                    'result_url'=>'http://www.yourdomain.com/result'
                );
                break;
            case 'jdpay_wap':
                $extra = array(
                    'success_url' => 'http://www.yourdomain.com',
                    'fail_url'=> 'http://www.yourdomain.com',
                    'token' => 'dsafadsfasdfadsjuyhfnhujkijunhaf'
                );
                break;
        }

        application\extensions\Pingpp\lib\Pingpp::setApiKey('sk_test_ibbTe5jLGCi5rzfH4OqPW9KC');


        try {
            $ch = $res = application\extensions\Pingpp\lib\Charge::create(
                array(
                    'subject'   => $subject,
                    'body'      => $body,
                    'amount'    => $amount,
                    'order_no'  => $orderNo,
                    'currency'  => 'cny',
                    'extra'     => $extra,
                    'channel'   => $channel,
                    'client_ip' => $_SERVER['REMOTE_ADDR'],
                    'app'       => array('id' => 'app_1Gqj58ynP0mHeX1q')
                )
            );
            if($res){
                $result = json_decode($res);
               if($result->id && $user_id = $params['user_id'])
               {

                   $order = array(
                       'user_id'=>$user_id,
                       'ping_id'=>$result->id,
                       'flag' =>$params['flag']?$params['flag']:0,
                       'app'=>$result->app,
                       'channel'=>$result->channel,
                       'order_no'=>$result->order_no,
                       'client_ip'=>$result->client_ip,
                       'amount' =>$result->amount,
                       'subject' =>$subject,
                       'body' =>$body,
                   );
                   if($result->paid){
                       $order['paid'] = 1;
                   }
                   if($result->time_paid)
                   {
                       $order['time_paid'] = $result->time_paid;
                   }
                   if($params['content']){
                       $order['flag_content'] = $params['content'];
                   }
                   $model = new Order();
                   $model->attributes = $order;
                   if($model->validate() && $model->save())
                   {
                       echo $ch;
                   }else{
                       echo json_encode($model->getErrors());
                   }
               }
            }


        } catch (application\extensions\Pingpp\lib\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            echo($e->getHttpBody());
        }

    }

}