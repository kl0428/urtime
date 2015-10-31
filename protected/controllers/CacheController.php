<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-6-19
 * Time: 下午4:28
 */
class CacheController extends Controller
{
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $cache = Yii::app()->cache_local;
        //$cache->auth('123456');
        $user1 = $cache->get('zhaoqing');
        var_dump($user1);
        echo "<br/>";
        $books = $cache->lrange('books',0,-1);
        var_dump($books);

        echo "<br/>";
        $test = $cache->lrange('test',0,-1);
        var_dump($test);

        echo "<br/>";
        $test = $cache->hgetall('shuiguo');
        var_dump($test);

        echo "<br/>";
        $test = $cache->hget('shuiguo','xiangjiao');
        var_dump($test);

        echo "<br/>";
        $test = $cache->zrange('myset',0,-1,'withscores');
        var_dump($test);
        echo "<br/>";
        $test = $cache->zrevrange('myset',0,-1,'withscores');
        var_dump($test);

        /* $redis = new Redis();
         $redis->connect('127.0.0.1',6379);
         $redis->auth('123456');
         $user = $redis->get('user');
         var_dump($user);
         exit();*/
        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        $cache2 = Yii::app()->cache_ext;
        $zhaoqing = $cache2->get('zhaoqing');
        var_dump($zhaoqing);
        echo "<br/>";
        $books = $cache2->lrange('books',0,-1);
        var_dump($books);
        echo "<br/>";
        $test2 = $cache2->lrange('test',0,-1);
        var_dump($test2);
        echo "<br/>";
        $test = $cache2->hgetall('shuiguo');
        var_dump($test);
        echo "<br/>";
        $test = $cache2->hget('shuiguo','xiangjiao');
        var_dump($test);
        echo "<br/>";
        $test = $cache2->zrange('myset',0,-1,'withscores');
        var_dump($test);
        echo "<br/>";
        $test = $cache2->zrevrange('myset',0,-1,'withscores');
        var_dump($test);
        exit();
    }
}