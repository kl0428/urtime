<?php
//namespace app\v0;
/**
 * app公共父service 存放验证日志等函数
 * @author xiaoyaozi
 * @date 2014-09-10
 */
class AppApiService	{
	
	public function __construct(){
		//TODO
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

?>