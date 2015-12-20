<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-12-8
 * Time: 下午4:32
 */
Yii::import("application.extensions.Qiniu.*");
use application\extensions\Qiniu\Auth;
use application\extensions\Qiniu\Storage\UploadManager;
function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/../extensions/' . $path . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('classLoader');

require_once  __DIR__ . '/../extensions/Qiniu/functions.php';
class ImageController extends Controller
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
   // protected $params; 		//接口参数

    //接口编号数组
    protected $APP_KEYS = array(
        '14325' => "android",//andriod
        '14326' => "ios",//ios
    );


    protected $Services = array(
        'register'              =>'UserService',//注册接口
        'sendSms'               =>'SmsService',//发送短信接口
        'login'                 =>'UserService',//登录接口
        'forget'                =>'UserService',//忘记密码
        'banner'                =>'CardService',//获取banner及通卡类型接口
        'cards'                 =>'CardService',//获取指定类型的通卡列表
        'cardInfo'              =>'CardService',//获取指定类型通卡信息
        'city'                  =>'CityService',//获取城市信息
        'provice'               =>'CityService',//获取省
        'cities'                =>'CityService',//获取省市
        'alliance'              =>'AllianceService',//创建/修改联盟信息
        'getAlliances'          =>'AllianceService',//获取联盟列表和指定联盟信息
        'quitAlliance'          =>'AllianceService',//删除并退出联盟
        'addAlliance'           =>'AllianceService',//申请加入联盟
        'addDynamic'            =>'AllianceService',//添加联盟动态
        'getDynamic'            =>'AllianceService',//获取联盟列表
        'addUserDynamic'        =>'AllianceService',//添加用户动态
        'getUserDynamic'        =>'AllianceService',//获取用户动态
        'pay'                   =>'PayService',//支付
        'addFocus'              =>'UserService',//添加关注
        'delFocus'              =>'UserService',//取消关注
        'getFocus'              =>'UserService',//获取关注
        'report'                =>'UserService',//举报和意见反馈接口
    );

    public function init()
    {
        $this->app_secret = Yii::app()->params['app']['MobileApiKey'];
        $this->app_key = $this->_post('app_key','14326');
        $this->app_sign = $this->_post('app_sign');
        $this->timestamp = $this->_post('timestamp');
        $this->method = $this->_post('method');
        $this->app_name = $this->_post('app_name');
        $this->app_version = $this->_post('app_version');
        $this->client = $this->_post('client');
        $this->net = $this->_post('net');
        $this->validtime = Yii::app()->params['app']['MobileApiValidtime'];
        //$this->params =json_decode($this->_post('params'),true);
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


    public function actionUpImages()
    {
        if (($return = $this->verify()) == true) {

            $accessKey = Yii::app()->params['qiniu']['accessKey'];
            $secretKey = Yii::app()->params['qiniu']['secretKey'];
            $auth = new Auth($accessKey, $secretKey);

            $bucket = 'urtime1';
            $token = $auth->uploadToken($bucket);
            $uploadMgr = new UploadManager();

            //上传介绍图片
            if ($_FILES['upImage']['name'] != null) {
                $images = $this->setImageInformation($_FILES, $token, $uploadMgr);
                if ($images) {
                    //$images_str = implode(',',$images);
                    $this->notice('OK', 0, '上传成功', $images);
                    Yii::app()->end();
                } else {
                    $this->notice('ERR', 307, $this->API_ERRORS[307]);
                }
            } else {
                $this->notice('ERR', 301, $this->API_ERRORS[301]);
            }
        }

    }
    //图片函数
    public function setImageInformation($image,$token,$uploadMgr){
        $images = array();
        foreach($image as $file){
            $name=$file['name'];
            $arr=explode('.',$name);
            $ext=$arr[count($arr)-1];
            $key="urtime".date("YmdHis").mt_rand(1,9999).".".$ext;
            $filePath = $file['tmp_name'];
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
            if ($err !== null) {
                $images ['err'][] = $err;
            } else {
                $images[] = $ret['key'];
            }

        }
        return $images;
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
}