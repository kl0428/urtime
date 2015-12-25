<?php
//ini_set("error_reporting","E_ALL & ~E_NOTICE");
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
//defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//defined('ENVIRONMENT') or define('ENVIRONMENT','PRODUCT');
//defined('ENVIRONMENT') or define('ENVIRONMENT','TEST');
defined('ENVIRONMENT') or define('ENVIRONMENT', 'DEVELOP');
//develop 开发  test测试  product线上


if (ENVIRONMENT == 'DEVELOP') {
    $config=dirname(__FILE__).'/protected/config/develop.php';
    // remove the following lines when in production mode
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 1);
}
if (ENVIRONMENT == 'TEST') {
    $config=dirname(__FILE__).'/protected/config/test.php';
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 0);
}

if (ENVIRONMENT == 'PRODUCT') {
    $config=dirname(__FILE__).'/protected/config/main.php';
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
}
require_once($yii);
Yii::createWebApplication($config)->run();
