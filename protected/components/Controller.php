<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/index';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	//接口错误信息数组
	protected $API_ERRORS = array(
		0 => '成功',
		301 => '缺少参数',
		302 => '签名错误',
		303 => '错误的APP_KEY',
		304 => '请求已过期',
		305 => '请求的接口不存在',
		306 => '请求数据获取失败',
		307 => '请求数据获取失败',
		308 => '请求数据错误',
		309 => '参数格式错误',
		310 => '非法用户',
		312 => '暂无数据'
	);

	protected  function cache()
	{
		$redis = new Redis();
		$redis->connect('127.0.0.1',6379);
		$redis->auth('123456');

		return $redis;
	}

	public function _get($name,$default = ''){
		return trim(Yii::app()->request->getParam($name,$default));
	}

	public function _post($name,$default = ''){
		return trim(Yii::app()->request->getPost($name,$default));
	}

	public function _isAjaxRequest(){
		return Yii::app()->request->isAjaxRequest;
	}
	public function _isPost(){
		return Yii::app()->request->isPostRequest;
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
}