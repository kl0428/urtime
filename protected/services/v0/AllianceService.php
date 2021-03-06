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
            $owner_arr = User::model()->loadUserByPk($user_id);
            if($owner_mobile=$owner_arr['mobile']) {
                $model->attributes = $alliance;
                if ($model->validate() && $model->save()) {
                    $id = $model->getPrimaryKey();
                    Yii::import("application.extensions.Emchat.*");
                    $h = new Easemob();
                    $options ['groupname'] = $name;
                    $options ['desc'] = (isset($notice) && $notice) ? $notice : "this is a love group";
                    $options ['public'] = true;
                    $options ['owner'] = 'ur_'.$owner_mobile;
                    $group = $h->createGroup($options);
                    if ($groupid = $group['data']['groupid']) {
                        $groups = array(
                            'name' => $name,
                            'owner' => 'ur_'.$owner_mobile,
                            'desc' => (isset($notice) && $notice) ? $notice : "this is a love group",
                            'emchat_id' => $groupid,
                            'alliance_id' => $id,
                        );
                        $emchat = new Emchat();
                        $emchat->attributes = $groups;
                        if ($emchat->validate() && $emchat->save()) {
                            $ret = $this->notice('OK', 0, '成功', $groups);
                        } else {
                            $ret = $this->notice('ERR', 307, '操作失败', $emchat->getErrors());
                        }
                    } else {
                        $ret = $this->notice('ERR', 306, '环信数据保存失败', $group);
                    }
                } else {
                    $ret = $this->notice('ERR', 305, '数据保存失败', $model->getErrors());
                }
            }else{
                $ret = $this->notice('ERR', 303, '用户数据不存在', []);
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
                        'logo'=>$val->image,
                        'name'=>$val->name,
                        'leader'=>$val->leader,
                        'leader_name'=>$val->user?$val->user->nickname:'-',//$val->user->nickname,
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
        if(isset($id)&&$id&&isset($type))
        {
            $dynamic = array(
                'dy_user'=>$id,
                'dy_type'=>$type?$type:0,
            );
            if(isset($content)&&$content)
            {
                $dynamic['dy_content'] = $content;
            }

            if(isset($image)&&$image)
            {
                if(!is_null(json_decode($image)))
                {
                    $images =json_decode($image);
                    $dynamic['dy_images'] = implode(',',$images);
                }else{
                    $dynamic['dy_images'] = $image;
                }
            }

            $model = new Dynamic();
            $model->attributes = $dynamic;
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
        if(isset($type)){
            if(!$type){
                if(isset($id)&&$id)
                {
                    $obj = Dynamic::model()->with('user')->findAll(array('condition'=>'dy_type=:type and dy_user=:dy_user',
                        'params'=>array(':type'=>$type,':dy_user'=>$id),
                        'order'=>'dy_num desc , t.gmt_created desc'
                    ));

                }else{

                    $obj = Dynamic::model()->with('user')->findAll(array('condition'=>'dy_type=:type',
                        'params'=>array(':type'=>$type),
                        'order'=>'dy_num desc , t.gmt_created desc',
                    ));
                }
            }else if($type == 1)
            {
                if(isset($id)&&$id)
                {
                    $obj = Dynamic::model()->with('alliance')->findAll(array('condition'=>'dy_type=:type and dy_user=:dy_user',
                        'params'=>array(':type'=>$type,':dy_user'=>$id),
                        'order'=>'dy_num desc , t.gmt_created desc'
                    ));

                }else{

                    $obj = Dynamic::model()->with('alliance')->findAll(array('condition'=>'dy_type=:type',
                        'params'=>array(':type'=>$type),
                        'order'=>'dy_num desc , t.gmt_created desc',
                    ));
                }
            }else{
                if(isset($id)&&$id)
                {
                    $obj = Dynamic::model()->findAll(array('condition'=>'dy_type=:type and dy_user=:dy_user',
                        'params'=>array(':type'=>$type,':dy_user'=>$id),
                        'order'=>'dy_num desc , t.gmt_created desc'
                    ));

                }else{

                    $obj = Dynamic::model()->findAll(array('condition'=>'dy_type=:type',
                        'params'=>array(':type'=>$type),
                        'order'=>'dy_num desc , t.gmt_created desc',
                    ));
                }
            }


            $dynamic = array();
            if($obj){
                foreach($obj as $key=>$val)
                {
                    if(!$type && !$val->user){
                        continue;
                    }elseif($type == 1&&$val->alliance)
                    {
                        continue;
                    }
                    $image = explode(',',$val->dy_images);
                    $images = array();
                    if($image){
                        foreach($image as $k=>$v){
                            $images[] = Yii::app()->params['qiniu']['host'].$v;
                        }
                    }
                    $dynamic[$key] = array(
                        'id'=>$val->dy_id,
                        'content'=>$val->dy_content,
                        'images'=>$images,
                        'num' =>$val->dy_agree,
                        'time' =>$val->gmt_created,
                    );
                    if($val->dy_id&&isset($user_id)&&$user_id){
                        $cache_ext = Yii::app()->cache_ext;
                        if(isset($user_id)&&$user_id&&$cache_ext->hget('Dynamic.'.$val->dy_id,$user_id)){
                            $dynamic[$key]['is_agree'] = 1;
                        }else{
                            $dynamic[$key]['is_agree'] = 0;
                        }
                    }else{
                        $dynamic[$key]['is_agree'] = 0;
                    }
                    if(!$type){
                        $dynamic[$key]['logo'] = Yii::app()->params['qiniu']['host'].$val->user->image;
                        $dynamic[$key]['nickname'] = $val->user->nickname;
                    }else if($type == 1){
                        $dynamic[$key]['logo'] = Yii::app()->params['qiniu']['host'].$val->alliance->image;
                        $dynamic[$key]['nickname'] = $val->alliance->name;
                    }
                    $dynamic[$key]['url'] = 'www.baidu.com';
                }

                $ret = $this->notice('OK',0,'成功',$dynamic);
            }else{
                $ret = $this->notice('OK',0,'暂无数据',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少关键参数',[]);
        }
        return $ret;
    }

    //关注对象

    public function getDetailDynamic($params = array())
    {
        extract($params);
        if(isset($id)&&$id){


                $obj = Dynamic::model()->find(array('condition'=>'dy_id=:id',
                    'params'=>array(':id'=>$id)
                ));

            $dynamic = array();
            if($obj){
                    $image = explode(',',$obj->dy_images);
                    $images = array();
                    if($image) {
                        foreach ($image as $key => $val) {
                            $images[] = Yii::app()->params['qiniu']['host'] . $val;
                        }
                    }
                    $dynamic = array(
                        'id'=>$obj->dy_id,
                        'content'=>$obj->dy_content,
                        'images'=>$images,
                        'num' =>$obj->dy_agree,
                        'time' =>$obj->gmt_created,
                    );
                $cache_ext = Yii::app()->cache_ext;
                if(isset($user_id)&&$user_id&&$cache_ext->hget('Dynamic.'.$id,$user_id)){
                    $dynamic['is_agree'] = 1;
                }else{
                    $dynamic['is_agree'] = 0;
                }
                if($obj->dy_type && $obj->dy_user){
                    if(!$obj->dy_type){
                        $user = User::model()->findByPk($obj->dy_user);
                        $dynamic['logo'] = Yii::app()->params['qiniu']['host'].$user->image;
                        $dynamic['nickname'] = $user->nickname;
                    }
                }elseif($obj->dy_type==1){
                    $alliance = Alliance::model()->findByPk($obj->dy_user);
                    $dynamic['logo'] = Yii::app()->params['qiniu']['host'].$alliance->image;
                    $dynamic['nickname'] = $alliance->name;
                }else{
                    $dynamic['logo'] = '';
                    $dynamic['nickname'] = '';
                }
                    $dynamic['url'] = 'www.baidu.com';
                $ret = $this->notice('OK',0,'成功',$dynamic);
            }else{
                $ret = $this->notice('OK',0,'暂无数据',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少关键参数',[]);
        }
        return $ret;
    }

    //删除动态
    public function deleteDynamic($params =array())
    {
        extract($params);
        if(isset($id)&&$id){
            $is_exists = Dynamic::model()->exists('dy_id=:id',array(':id'=>$id));
            if($is_exists){
                if(Dynamic::model()->deleteByPk($id)){
                    $ret = $this->notice('OK',0,'成功',[]);
                }else{
                    $ret = $this->notice('ERR',307,'操作数据错误',[]);
                }
            }else{
                $ret = $this->notice('ERR',306,'获取不到数据',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少关键参数',[]);
        }
        return $ret;
    }

    public function agree($params = array()){
        extract($params);
        if(isset($id)&&$id&&isset($user_id)&&$user_id){
            $cache_ext = Yii::app()->cache_ext;
            if(!$cache_ext->hget('Dynamic.'.$id,$user_id)){
                $model = Dynamic::model()->findByPk($id);
                if($model){
                    $user = array('dy_agree'=>$model->dy_agree+1);
                    $model->attributes = $user;
                    if($model->save()&&$model->validate()){
                        $cache_ext->hset('Dynamic.'.$id,$user_id,1);
                        $ret = $this->notice('OK',0,'成功',[]);
                    }else{
                        $ret = $this->notice('ERR',307,'操作数据错误',[]);
                    }
                }else{
                    $ret = $this->notice('ERR',306,'获取不到数据',[]);
                }
            }else{
                $ret = $this->notice('ERR',305,'已经点赞过了',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少关键参数',[]);
        }

        return $ret;
    }

    //添加评论
    public function addComment($params =array())
    {
        extract($params);
        if(isset($dynamic_id)&&isset($user_id)&&$user_id&&$dynamic_id)
        {
            $comment  = array(
                'dynamic_id'=>$dynamic_id,
                'user_id' =>$user_id,
            );
            if(isset($content)&&$content)
            {
                $comment['content'] = $content;
            }

            if(isset($image)&&$image){
                if(!is_null(json_decode($image)))
                {
                    $images =json_decode($image);
                    $comment['images'] = implode(',',$images);
                }else{
                    $comment['images'] = $image;
                }
            }
            if(isset($content)&&$content||isset($image)&&$image){
                $model = new Comments();
                $model->attributes = $comment;
                if($model->validate()&&$model->save())
                {
                    $ret = $this->notice('OK',0,'成功',[]);
                }else{
                    $ret = $this->notice('ERR',307,'操作数据错误',$model->getErrors());
                }
            }else{
                $ret = $this->notice('ERR',303,'没有评论内容',[]);
            }

        }else{
            $ret = $this->notice('ERR',301,'缺少关键参数',[]);
        }

        return $ret;
    }

    //获取评论列表
    public function getComment($params=array())
    {
        extract($params);
        if(isset($dynamic_id)&&$dynamic_id){
            $obj = (array)Comments::model()->with('user')->findAll('dynamic_id=:dynamic and is_del=:del',array(':dynamic'=>$dynamic_id,'del'=>'0'));
            $comments = array();
            if($obj){
                foreach($obj as $key=>$val)
                {
                    $image = array();
                    if($val->images){
                        $image = explode(',',$val->images);
                    }
                    if($val->user){
                        $comments[] = array(
                            'nickname'=> $val->user->nickname,
                            'logo'  =>$val->user->image,
                            'content' =>$val->content,
                            'images'  =>$image,
                            'time'    =>$val->gmt_created,
                        );
                    }
                }
            }

            $ret = $this->notice('OK',0,'成功',$comments);
        }else{
            $ret = $this->notice('ERR',301,'缺少关键参数',[]);
        }

        return $ret;
    }



}