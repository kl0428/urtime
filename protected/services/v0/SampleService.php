<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-11-1
 * Time: 上午9:29
 */
//namespace app\v0;
/**
 * 单独处理个别app请求service 样例
 * @author xiaoyaozi
 * @date 2014-09-10
 */
class SampleService extends AppApiService{

    /**
     *
     * 显示样例，以显示商品列表为例，模拟brandlist_data_get的功能
     * @param $param
     * @return array
     */
    public function showSample($param)
    {
        $result=array(
            'total_count' => 1,
            'itemslist' => array(0=>12,1=>23),
            'order_wait_pay'	=> 12
        );
        $ret = $this->notice('OK', 0, '', $result);
        return $ret;
    }
}