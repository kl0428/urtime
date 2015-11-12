<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-11-12
 * Time: 下午3:25
 */

class CityService extends AppApiService
{
    //获取城市列表
    public function city($params =array()){
        extract($params);
        if(isset($provice)){
            $city =array();
            $cache = Yii::app()->cache;
            if($city = $cache->hget('provice',$provice))
            {
                $city = CJSON::decode($city);
            }else{
                $city_obj = YhmCity::model()->findAll('class_parent_id=:id',array(':id'=>$provice));

                if($city_obj){
                    foreach($city_obj as $key=>$val)
                    {
                        $city[] = array('id'=>$val->class_id,'name'=>$val->class_name);
                    }

                    $cache->hset('provice',$provice,json_encode($city,JSON_UNESCAPED_UNICODE));
                }
            }
            $result = array(
                'city'=>$city,
            );
            return $this->notice('OK',0,'成功',$result);
        }else{
            return $this->notice('ERR',301,'缺少参数',[]);
        }

    }

    //获取省列表
    public function provice($params =array())
    {
        $cache = Yii::app()->cache;
        if($provices =$cache->hget('city','provice')){
            $provices = CJSON::decode($provices);
        }else{
            $provice_obj = YhmCity::model()->findAll('class_parent_id=:id',array(':id'=>1));
            $provices =array();
            if($provice_obj){
                foreach($provice_obj as $key=>$val)
                {
                    $provices[] = array('id'=>$val->class_id,'name'=>$val->class_name);
                }

                $cache->hset('city','provice',json_encode($provices,JSON_UNESCAPED_UNICODE));
            }
        }
        $result =array(
            'provices'=>$provices,
        );

        return $this->notice('OK',0,'成功',$result);

    }

    public function cities($params = array())
    {
        $cache = Yii::app()->cache;
        if($city_all = $cache->hget('city','cities'))
        {
            $provices = CJSON::decode($city_all);
        }else{
            //获取全国省列表
            $provice_obj = YhmCity::model()->findAll('class_parent_id=:id',array(':id'=>1));
            $provices =array();
            if($provice_obj){
                foreach($provice_obj as $key=>$val)
                {
                    $provices[$val->class_id] = array('id'=>$val->class_id,'name'=>$val->class_name);
                }
            }

            $obj = YhmCity::model()->findAll('class_parent_id >:id and class_type = :type',array(':id'=>1,':type'=>2));
            if($obj){
                foreach($obj as $key=>$val)
                {
                    if($val->class_parent_id > 1){

                    }
                    $provices[$val->class_parent_id]['cites'][] = array('id'=>$val->class_id,'name'=>$val->class_name);
                }

                $cache->hset('city','cities',json_encode($provices,JSON_UNESCAPED_UNICODE));
            }
        }
        $result =array(
            'cities'=>$provices,
        );

        return $this->notice('OK',0,'成功',$result);
    }
}