<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-7-23
 * Time: 下午1:21
 */ class LreanController extends Controller
{
    public function actionRask()
    {
        ob_start(); //打开缓冲区
        phpinfo(); //使用phpinfo函数
        $info=ob_get_contents(); //得到缓冲区的内容并且赋值给$info
        $file=fopen(Yii::app()->baseUrl.'assets/'.'info.txt','w'); //打开文件info.txt
        fwrite($file,$info); //写入信息到info.txt
        fclose($file); //关闭文件info.txt
        ob_end_flush();
    }

    public function actionSocket()
    {
        /*socket php 客户端*/
        header('Contenttype:text/html;charset=utf8');
        $host = 'tcp://localhost:9999';
        $fp = stream_socket_client($host,$errno,$error,30);
        if(!$fp)
        {
            echo "$error($errno)";
        }else{
            fwrite($fp,'one|two|three');
            while(!feof($fp))
            {
                echo fgets($fp);
            }
        }
        fclose($fp);
    }
}