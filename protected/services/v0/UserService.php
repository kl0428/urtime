<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-11-2
 * Time: 下午8:35
 */

class UserService extends AppApiService
{
    /*
     * 方法名称：注册
     * @param string nickname
     * @param  string password
     * @return int userid
     * */
    public function register($params=array())
    {
        extract($params);
        if(isset($nickname) && isset($password)){

        }else{
            $ret = $this->notice('ERR', 307, '', $result);
        }
        $result=array(
            'password' => $params['password'],
        );
        $ret = $this->notice('ERR', 307, '', $result);
        return $ret;
    }
}