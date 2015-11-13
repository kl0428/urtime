<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-11-13
 * Time: 下午2:03
 */
class AllianceService extends AppApiService
{
    //create and update
    public function alliance($params = array())
    {
       extract($params);
        $alliance = array();
        if(isset($alliance_id)&& $alliance_id){
            $model = Alliance::model()->findByPk($alliance_id);
        }else{
            $model = new Alliance();
            $alliance['type'] = 0;
        }
        if(isset($name)&&$name)
            $alliance['name'] =$name;

        if(isset($center_name)&&$center_name)
            $alliance['center_name'] = $center_name;

        if(isset($image) && $image)
            $alliance['image'] = $image;

        if(isset($notice) && $notice)
            $alliance['notice'] = $notice;

        if(isset($user_id)&&$user_id){
            $alliance['leader'] = $user_id;
            $model->attributes = $alliance;
            if($model->validate() && $model->save())
            {
                $id = $model->getPrimaryKey();
                $result = array(
                    'id' => $id,
                );
                $ret = $this->notice('OK',0,'成功',$result);
            }else{
                $res = $this->notice('ERR',305,'数据保存失败',$model->getErrors());
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
        return $ret;
    }
}