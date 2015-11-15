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

    //获取联盟列表

    public function getAlliances($params=array())
    {
        extract($params);
        if(isset($alliance_id) && $alliance_id)
        {

            $alliance = Alliance::model()->getAlliance($alliance_id);

            if($alliance)
            {
                $result = $alliance;
                $ret = $this->notice('OK',0,'成功',$result);
            }else{
                $ret = $this->notice('ERR',306,'请求数据不存在',[]);
            }
        }else{
            $obj = Alliance::model()->with('user')->findAll();
            $alliance = array();
            if($obj)
            {
                foreach($obj as $key=>$val)
                {
                    $alliance[] =array(
                        'id'=>$val->id,
                        'name'=>$val->name,
                        'leader'=>$val->leader,
                        'leader_name'=>$val->user->nickname,
                        'type'=>$val->type,
                        'center_name'=>$val->center_name,
                        'notice'=>$val->notice,
                    );
                }
                $result = $alliance;
                $ret = $this->notice('OK',0,'成功',$result);
            }else{
                $ret = $this->notice('ERR',306,'获取数据信息不存在',[]);
            }
            return $ret;
        }
        return $ret;
    }

    //退出联盟
    public function quitAlliance($params = array()){
        extract($params);
        if(isset($user_id)&&$user_id &&isset($alliance_id)&& $alliance_id)
        {
            //获取联盟信息
            $obj = Alliance::model()->findByPk($alliance_id);
            if($user_id == $obj->leader)
            {
                //获取加入时间最长的其他成员
                $member = Relations::model()->find(array(
                    'select'=>array('id','name'),
                    'condition'=>'user_id !=:user_id',
                    'params'=>array(':user_id'=>$obj->leader),
                    'order' =>'gmt_created asc',
                ));
                if($member)
                {   $delete =Relations::model()->delete('user_id=:user_id and alliance_id=:alliance_id',array(':user_id'=>$obj->leader,':alliance_id'=>$alliance_id));
                    $update = Alliance::model()->updateByPk($alliance_id,['leader'=>$member->id]);
                    if($delete && $update)
                    {
                        $ret = $this->notice('OK',0,'成功',['alliance_id'=>$alliance_id]);
                    }else{
                        $ret = $this->notice('ERR',307,'数据操作失败',['alliance_id'=>$alliance_id]);
                    }
                }
            }else{
                $delete =Relations::model()->delete('user_id=:user_id and alliance_id=:alliance_id',array(':user_id'=>$obj->leader,':alliance_id'=>$alliance_id));
                if($delete)
                {
                    $ret = $this->notice('OK',0,'成功',['alliance_id'=>$alliance_id]);
                }else{
                    $ret = $this->notice('ERR',307,'数据操作失败',['alliance_id'=>$alliance_id]);
                }
            }
            return $ret;
        }else{
            return $this->notice('ERR',301,'缺少参数',[]);
        }
    }

    //加入联盟
    public  function addAlliance($params = array())
    {
        extract($params);
        if(isset($user_id)&&$user_id&&isset($alliance_id)&&$alliance_id)
        {
            //检查是否申请过
            $obj = Relations::model()->find(array('select'=>array('id'),
                'condition'=>'user_id=:user_id and alliance_id=:alliance_id',
                'params'=>array(':user_id'=>$user_id,':alliance_id'=>$alliance_id)
            ));
            if(!$obj){
                $relation = new Relations();
                if($relation->validate() && $relation->save()){
                    $id = $relation->getPrimaryKey();
                    $result = array(
                        'id'=>$id,
                    );
                    $ret = $this->notice('OK',0,'成功',$result);
                }else{
                    $ret = $this->notice('ERR',306,'操作失败',$relation->getErrors());
                }
            }else{
                $result = array(
                    'id'=>$obj->id,
                );
                $ret = $this->notice('ERR',305,'数据已经存在',$result);
            }
            return $ret;
        }else{
            return $this->notice('ERR',301,'缺少参数',[]);
        }
    }

    //联盟动态
    //添加联盟动态
    public function addDynamic($params = array())
    {
        extract($params);
        if(isset($alliance_id)&&$alliance_id)
        {
            $dynamic = array(
                'dy_user'=>$alliance_id,
                'dy_type'=>1,
            );
            if(isset($content)&&$content)
            {
                $dynamic['dy_content'] = $content;
            }

            if(isset($image)&&$image)
            {
                if(is_null(json_decode($image)))
                {
                    $images =json_decode($image);
                    $dynamic['dy_images'] = implode(',',$images);
                }else{
                    $dynamic['dy_images'] = $image;
                }
            }

            $model = new Dynamic();
            if($model->validate()&&$model->save())
            {
                $id = $model->getPrimaryKey();
                $result = array(
                    'id'=>$id
                );
                $ret = $this->notice('OK',0,'成功',$result);
            }else{
                $ret = $this->notice('ERR',307,'操作数据错误',$model->getErrors());
            }
            return $ret;
        }else{
            return $this->notice('ERR',301,'缺少关键参数',[]);
        }
    }


    //获取联盟列表
    public function getDynamic($params = array())
    {
        extract($params);
        if(isset($alliance_id)&&$alliance_id)
        {
            $obj = Dynamic::model()->findAll(array('condition'=>'dy_type=:type and dy_user = :user',
                'params'=>array(':type'=>1,':user'=>$alliance_id),
                'order'=>'gmt_created desc',
            ));

        }else{

            $obj = Dynamic::model()->findAll(array('condition'=>'dy_type=:type',
                'params'=>array(':type'=>1),
                'order'=>'gmt_created desc',
            ));
        }
        $dynamic = array();
        if($obj){
            foreach($obj as $key=>$val)
            {
                $image = explode(',',$val->dy_images);
                $dynamic[] = array(
                    'id'=>$val->dy_id,
                    'content'=>$val->dy_content,
                    'images'=>$image
                );
            }
            $ret = $this->notice('OK',0,'成功',$dynamic);
        }else{
            $ret = $this->notice('ERR',306,'获取不到数据',[]);
        }
        return $ret;
    }
}