<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-6-19
 * Time: 下午1:25
 */
class IndexController extends Controller
{

    //接受全局参数
    protected $app_key; 	//接口编号
    protected $timestamp; 	//时间戳
    protected $method; 		//接口名称
    protected $app_secret; 	//接口密钥
    protected $app_sign; 	//接口签名
    protected $validtime; 	//有效期
    protected $app_name; 	//应用接口名称
    protected $app_version; //应用版本号
    protected $client; 		//客户端类型
    protected $net; 		//客户端网络状态
    protected $params; 		//接口参数

    //接口编号数组
    protected $APP_KEYS = array(
        '14325' => "android",//andriod
        '14326' => "ios",//ios
    );


    protected $Services = array(
        'register' =>'UserService',//注册接口
        'sendSms'  =>'SmsService',//发送短信接口
    );


    public function __construct()
    {
        $this->app_secret = Yii::app()->params['app']['MobileApiKey'];
        $this->app_key = $this->_post('app_key','14325');
        $this->app_sign = $this->_post('app_sign');
        $this->timestamp = $this->_post('timestamp');
        $this->method = $this->_post('method');
        $this->app_name = $this->_post('app_name');
        $this->app_version = $this->_post('app_version');
        $this->client = $this->_post('client');
        $this->net = $this->_post('net');
        //$this->params =json_decode($this->_post('params'),true);


    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {

        $return ='';
       // if (($return = $this->verify()) == true) {

//            global $_APP_KEY;
//            $_APP_KEY=$this->APP_KEYS[$this->app_key];
             $this->params = $_REQUEST['params'];


            $model = $this->method;//方法类型

            if(empty($model)){
                $this->notice('ERR',301,"参数不全");
            }
            $version_str = "v0";//APP版本号所对应的API版本号

            $arr_v1 = array("1.2.0","12","2.0.0","14");//v1版本对应app_version

            if(in_array($this->app_version, $arr_v1)){
                $version_str = "v1";
            }
            if(in_array($model,array_keys($this->Services)))
            {
                $serv = new $this->Services[$model]();
                $return = $serv->$model($this->params);
            }

            //新接口开始走api自己的service层
//            if($model == "sample"){

//                $classStr = 'app.'.$version_str.'.SampleService';//service名称
//                $className = new ReflectionClass($classStr);
//                $serv  = $className->newInstance();
//                $serv = new SampleService();

//                $return = $serv->showSample($this->params);
//            }
//        }
        print_r($return);
        exit();
    }

    //验证
    protected function verify(){
        if($this->verifyKey()){
            if($this->verifyTime()){
                //if($this->verifyModule()){
                return true;
                //}
            }
        }
        return false;
    }

    //验证签名
    private function verifyKey(){
        $md5_sign = md5($this->app_key.$this->method.$this->timestamp.$this->app_secret);
        //判断签名
        if($md5_sign==$this->app_sign){
            return true;
        }else{
            //签名错误
            $this->notice('ERR',302,$this->API_ERRORS[302]);
        }
    }

    //验证时效
    private function verifyTime(){
        $nowtime = time();
        //判断请求时间
        if($nowtime <= ($this->timestamp+$this->validtime) && $nowtime >= ($this->timestamp-$this->validtime)){
            return true;
        }else{
            //请求时间无效
            $this->notice('ERR',304,$this->API_ERRORS[304]);
        }
    }

    /**
     *
     * 公共返回处理函数
     * @param string $status
     * @param string $code
     * @param unknown $msg
     * @param unknown $data
     */
    protected function notice($status='ERR',$code='-1',$msg,$data=array()){
        $notice = array(
            "status" => $status,
            "msg" => $msg,
            "code" => $code,
            "data" => $data
        );
        echo json_encode($notice);
        exit;
    }

    public function actionReq()
    {
        $appsecret = "123456";
        $action = $this->_get('action');
        $data = array(
            "app_key" => "14326",
            "timestamp" => time(),
            "method" => $action,
            "client"	=>'ios',
            //购物车列表
            "params" => array(
                "cookie_cart_id"=>array(327)
            ),

        );

        $data['action'] =$action;
        $data['user_id'] = 120;
        $data['user_token'] = md5(md5(uniqid('cnbeir'.$data['user_id'])));
        $data["app_sign"] = md5($data["app_key"].$data["method"].$data["timestamp"].$appsecret);
        $this->render('req',['data'=>$data]);
    }

    public function actionUpImage()
    {
        /*var_dump($_POST);
        exit();
        $this->params = $_REQUEST['params'];
        var_dump($this->params);
        exit;*/
        $image = CUploadedFile::getInstanceByName('params[file]');
        $dir=Yii::app()->basePath.'/../assets/images/heard/';
        $ext_arr = explode('.',$image->name);
        $ext = $ext_arr[count($ext_arr)-1];
        $name = 'heard'.time().'_'.rand(1, 9999).'.'.$ext;
        //文件名绝对路径

        $status = $image->saveAs($dir.$name,true);
        //保存文件
        if ($status) {
            $result=array('name'=>$name);
            $this->notice('OK',0,$result);
        }else {
            $this->notice('ERR',307,$this->API_ERRORS[307]);
        }
    }
}