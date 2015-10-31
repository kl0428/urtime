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
	public $layout='//layouts/column1';
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
}