<?php
/**
 * Created by JetBrains PhpStorm.
 * User: geminiblue
 * Date: 13-10-25
 * Time: 下午5:52
 * To change this template use File | Settings | File Templates.
 */
Yii::import('application.components.Snoopy');

class HttpLib
{
    /**
     * @param $url
     * @param $post_data
     * @return mixed|null
     */
    public static function post($url,$post_data)
    {
//        $post_data['_ts']=time();
        $session = new CHttpSession();
        $session->open();
        $post_data['token'] = $session['token'];

        if(false!==($apiName=array_search($url,Yii::app()->params["scripts"])))
        {
            //var_dump($apiName);
            return Yii::app()->api->postData($apiName,$post_data);
        }
        $sdata = array();
        foreach($post_data as $key=>$value)
        {
            $sdata[$key] = urlencode(trim($value));
        }
        try
        {
            $_snoopy = new Snoopy();

            $data = null;
            $furl = Yii::app()->params['back_host'].$url;
//            var_dump($furl,json_encode($sdata));
            $_snoopy->submit($furl,$sdata);
            if($_snoopy->status!=0)
            {
                Yii::log(json_encode(array('url'=>$url,'msg'=>$_snoopy->response_code)),'error','api.http.request');
                if($_snoopy->error)
                    Yii::log(json_encode(array('url'=>$url,'msg'=>$_snoopy->error)),'error','api.http.request');
                return null;
            }
//            var_dump($_snoopy->results);
            if($_snoopy->results!='')
                $data = json_decode($_snoopy->results,false);
            return $data;
        }catch (Exception $ex)
        {
            return null;
        }

        return null;
    }

    /**
     * @param $url
     * @param string $post_data
     * @return mixed|null
     */
    public static function get($url,$post_data='',$host='')
    {

        $str = '';
        if(is_array($post_data))
        {
//            $post_data['_ts']=time();
            $session = Yii::app()->session;
            $post_data['token'] = $session['token'];
            foreach($post_data as $key=>$value)
            {
                $str.='&'.$key.'='.urlencode(trim($value));
            }
        }
        if(false!==($apiName=array_search($url,Yii::app()->params["scripts"])))
        {
            return Yii::app()->api->fetchData($apiName,$post_data);
        }
        try
        {
            $url = (isset($host) && $host!='')?$host.$url:Yii::app()->params['back_host'].$url;

            $furl = $url.'?'.substr($str,1,strlen($str));
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $furl);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $data = curl_exec($ch);
            curl_close($ch);
            if($data===false)
                return false;
            return json_decode($data,false);
        }catch (Exception $ex)
        {
            return null;
        }
        return null;
    }
    /**
     * @return mixed
     */
    public static function getRemoteIp()
    {
        $unknown = 'unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        /*
                处理多层代理的情况
                或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
        */
        if (false !== strpos($ip, ',')) $ip = reset(explode(',', $ip));
        return $ip;
    }


    public static function E($errorCode)
    {
        return isset(Yii::app()->params['error_code'][$errorCode])?CHtml::encode(Yii::app()->params['error_code'][$errorCode]):'未知';
    }
}
