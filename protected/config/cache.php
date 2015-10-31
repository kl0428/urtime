<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-6-19
 * Time: 下午1:39
 */
return array(
    'components'=>array(
        'cache'=>array(
            'class'=>'ext.redis.CRedisCache',
            'keyPrefix' => false,
            'hashKey'   => false,
            'servers'   => array(
                array(
                    'host' =>'127.0.0.1',
                    'port' => '6379',
                    'password' => '123456',
                ),
            ),
        ),
    ),
);