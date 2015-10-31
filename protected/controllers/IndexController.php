<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-6-19
 * Time: 下午1:25
 */
class IndexController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {

        echo "<h1>欢迎进入优时</h1><br>";

       // $this->render('index');
    }
}