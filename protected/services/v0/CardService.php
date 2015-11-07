<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-11-7
 * Time: 下午2:17
 */
class CardService extends AppApiService
{
    //获取banner信息接口
    public function banner($params=array())
    {
        //获取最新banner图片列表
        $images = Banner::model()->getBannerList();
        //获取通卡信息列表
        $cards = Yii::app()->params['cards'];
        return $this->notice('OK',0,'成功',['images'=>$images,'cards'=>$cards]);
    }

    //获取通卡信息
    public function cards($params =array())
    {
        extract($params);
        if(isset($key))
        {
            $result = CardType::model()->getTypeCards($key);
            if($result){
                $ret = $this->notice('OK',0,'成功',$result);
            }else{
                $ret = $this->notice('OK',0,'成功',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
        return $ret;
    }

    //获取指定通卡信息
    public function cardInfo($params = array())
    {
        extract($params);
        if(isset($type_id)){
            $num = isset($num)&& $num > 0?$num:1;
            $result = Card::model()->getCards($type_id,$num);
            if($result){
                $ret = $this->notice('OK',0,'成功',$result);
            }else{
                $ret = $this->notice('OK',0,'成功',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
        return $ret;
    }
}