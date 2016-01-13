<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-11-2
 * Time: 下午8:35
 */

class UserService extends AppApiService
{
    /*
     * 方法名称：注册
     * @param string nickname
     * @param  string password
     * @return int userid
     * */
    public function register($params=array())
    {
        extract($params);
        if(isset($nickname) && isset($password)&& isset($mobile)){
            $cache = Yii::app()->cache;
            $save_code = strtolower($cache->hget($mobile,'register'));
            if(isset($code)&& $save_code==strtolower($code)) {
                //查询手机是否注册过
                $user = User::model()->exists(array('condition' => 'mobile=:mobile', 'params' => array(':mobile' => isset($mobile) ? $mobile : 0)));
                if (!$user) {
                    Yii::import("application.extensions.Emchat.*");
                    $h=new Easemob();
                    if(isset($mobile)&&$mobile){
                        $ur_name = 'ur_'.$mobile;
                        $pwd = isset($password)?$password:'123456';
                        $res=$h->createUser($ur_name,$pwd);
                    }

                    $result = array(
                        'nickname' => $nickname,
                        'sex' => isset($sex) ? $sex : 0,
                        'mobile' => isset($mobile) ? $mobile : 0,
                        'image' => isset($image) ? $image : '',
                        'password' => md5($mobile . md5($password)),
                    );
                    if($uuid=$res['entities'][0]['uuid']){
                        $result['uuid'] = $uuid;
                    }
                    $model = new User();
                    $model->attributes = $result;
                    if ($model->validate() && $model->save()) {
                        $id = $model->getPrimaryKey();
                        $res = array(
                            'id' => $id,
                            'nickname' => $nickname,
                            'uuid' =>$uuid
                        );
                        $ret = $this->notice('OK', 0, '成功', $res);
                    } else {
                        $ret = $this->notice('ERR', 307, '', $model->getErrors());
                    }

                } else {
                    $ret = $this->notice('ERR', 306, '该号码已经注册过了', []);
                }
            }else{
                $ret = $this->notice('ERR', 305, '验证码错误', ['code'=>$code,'save_code'=>$save_code]);
            }
        }else{
            $ret = $this->notice('ERR', 307, '', []);
        }
        $result=array(
            'password' => $params['password'],
        );
        $ret = $this->notice('ERR', 307, '', $result);
        return $ret;
    }

    public function login($params = array()){
        extract($params);
        if(!empty($username)&&isset($password)) {
            //查询手机是否注册过
            $user = User::model()->find('nickname=:nickname or mobile=:mobile',array(':nickname'=>$username,':mobile'=>$username));
            if($user) {
                $pwd = md5($user->mobile.md5($password));
                if ($pwd == $user->password) {
                    $result = array(
                        'id' => $user->id,
                        'nickname' => $user->nickname,
                        'mobile' => $user->mobile,
                        'username' => $user->username,
                        'uuid'  =>$user->uuid,
                    );
                    $ret = $this->notice('OK', 0, '', $result);
                } else {
                    $ret = $this->notice('ERR', 310, '登录失败', []);
                }
            }else{
                $ret = $this->notice('ERR', 311, '登录失败', []);
            }

         }else{
            $ret = $this->notice('ERR', 301, '缺少参数',[]);
        }
         return $ret;
    }

    //忘记密码
    public function forget($params=array())
    {
        extract($params);
        if(!empty($mobile)&&!empty($newpwd)){
            $cache = Yii::app()->cache;
            $save_code = strtolower($cache->hget($mobile,'forget'));
            if(isset($code)&& $save_code==strtolower($code)){
                //$model = new User();
                $user = User::model()->find(array('condition'=>'mobile=:mobile','params'=>array(':mobile'=>$mobile)));
                if($user){
                    $new_pwd = md5($user->mobile.md5($newpwd));
                    if(User::model()->updateAll(array('password'=>$new_pwd,'gmt_modified'=>date('Y-m-d H:i:s')),'mobile=:mobile',array(':mobile'=>$mobile))){
                        $ret = $this->notice('OK',0,'修改成功',array('pwd'=>$new_pwd));
                    };
                }else{
                    $ret = $this->notice('ERR',309,"该用户不存在",array('error'=>serliaize($user)));
                }
            }else{
                $ret = $this->notice('ERR',301,'缺少参数',array('code'=>$code,'save_code'=>$save_code));
            }
            return $ret;
        }
    }

    //个人信息更新
    public function update($params = array())
    {
        extract($params);
        if(isset($id)&&$id){
            $model = User::model()->findByPk($id);
            if($model){
                $user = array();
                if(isset($nickname)&&$nickname){
                    $user['nickname'] = $nickname;
                }
                if(isset($username)&&$username){
                    $user['username'] = $username;
                }
                if(isset($mobile)&&$mobile){
                    $user['mobile'] = $mobile;
                }
                if(isset($email)&&$email)
                {
                    $user['email'] = $email;
                }
                if(isset($sex)&&$sex)
                {
                    $user['sex'] = $sex;
                }
                if(isset($image)&&$image)
                {
                    $user['image']=$image;
                }
                if(isset($province)&&$province)
                {
                    $user['province'] = $province;
                }
                if(isset($city)&&$city)
                {
                    $user['city'] = $city;
                }
                $model->attributes = $user;
                if($model->validate()&&$model->save()){
                    $ret = $this->notice('OK',0,'修改成功',$user);
                }else{
                    $ret = $this->notice('ERR',307,'修改失败',$model->getErrors());
                }

            }else{
                $ret = $this->notice('ERR',304,'该用户不存在',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
        return $ret;
    }

    //获取用户信息
    public function user($params = array()){
        extract($params);
        if(isset($id)&&$id){
            $model = User::model()->findByPk($id);
            if($model){
                $user = array();
                    $user['nickname'] = $model->nickname;
                    $user['username'] = $model->username;
                    $user['mobile'] = $model->mobile;
                    $user['email'] = $model->email;
                    $user['sex'] = $model->sex;
                    $user['image']=Yii::app()->params['qiniu']['host'].$model->image;
                    $user['province'] = $model->province;
                    $user['city'] = $model->city;
                    $user['uuid'] = $model->uuid;
                if($user){
                    $ret = $this->notice('OK',0,'查询成功',$user);
                }else{
                    $ret = $this->notice('ERR',307,'查询失败',$model->getErrors());
                }

            }else{
                $ret = $this->notice('ERR',304,'该用户不存在',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
        return $ret;
    }

    //添加关注
    public function addFocus($params = array())
    {
        extract($params);
        if(isset($focus_user)&&$focus_user&&isset($user_id)&&$user_id&&isset($focus_type))
        {
            $focus = array(
                'focus_user' =>$focus_user,
                'user_id'    =>$user_id,
                'focus_type' =>$focus_type?$focus_type:0,
            );
            $cache = Yii::app()->cache;
            $cache->del('Focus.User.'.$user_id);
            $model = new Focus();
            $model->attributes = $focus;
            if($model->validate() && $model->save())
            {
                $ret = $this->notice('OK',0,'成功',['id'=>$model->getPrimaryKey()]);
            }else{
                $ret = $this->notice('ERR',306,'数据错误',$model->getErrors());
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
        return $ret;
    }

    //取消关注
    public function delFocus($params = array())
    {
        extract($params);
        if(isset($focus_id)&&$focus_id&&isset($user_id)&&$user_id)
        {
            $cache = Yii::app()->cache;
            $cache->del('Focus.User.'.$user_id);

            $focus = Focus::model()->find('focus_id=:focus_id and user_id=:user_id',array(':focus_id'=>$focus_id,'user_id'=>$user_id));
            if($focus->update(['is_focus'=>'0']))
            {
                $ret = $this->notice('OK',0,'成功',['id'=>$focus_id]);
            }else{
                $ret = $this->notice('ERR',306,'数据错误',$focus->getErrors());
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
        return $ret;
    }
    //
    public function getFocus($params = array())
    {
        extract($params);
        if(isset($user_id)&&$user_id)
        {
            $focus_arr = array();
            $focus_user = Focus::model()->with('user')->findAll(array('condition'=>'user_id=:user_id and focus_type < :type and is_focus=:focus','params'=>array(':user_id'=>$user_id,':type'=>'1',':focus'=>'1')));
            if($focus_user){//个人关注

                foreach($focus_user as $key=>$val)
                {
                    $focus_arr[] = array(
                        'user_name' =>$val->user->nickname,
                        'image' =>Yii::app()->params['qiniu']['host'].$val->user->image,
                        'focus_id' =>$val->focus_id,
                        'type'=>0,
                    );
                }

            }
            $focus_alliance = Focus::model()->with('alliance')->findAll(array('condition'=>'user_id=:user_id and focus_type = :type and is_focus = :focus','params'=>array(':user_id'=>$user_id,':type'=>'1',':focus'=>'1')));
            if($focus_alliance){//联盟关注

                foreach($focus_alliance as $key=>$val)
                {
                    $focus_arr[] = array(
                        'user_name' =>$val->alliance->name,
                        'image' =>Yii::app()->params['qiniu']['host'].$val->alliance->image,
                        'focus_id' =>$val->focus_id,
                        'type'=>0,
                    );
                }

            }
            $focus_store = Focus::model()->with('store')->findAll(array('condition'=>'user_id=:user_id and focus_type = :type and is_focus = :focus','params'=>array(':user_id'=>$user_id,':type'=>'2',':focus'=>'1')));
            if($focus_store){//联盟关注
                foreach($focus_store as $key=>$val)
                {
                    $focus_arr[] = array(
                        'user_name' =>$val->store->name,
                        'image' =>Yii::app()->params['qiniu']['host'].$val->store->image,
                        'focus_id' =>$val->focus_id,
                        'type'=>0,
                    );
                }

            }
            if($focus_arr){
            $result = $focus_arr;
                $ret = $this->notice('OK',0,'成功',$result);
            }else{
                $ret = $this->notice('OK',0,'没有关注对象',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
        return $ret;
    }

    //举报和意见反馈
    public function report($params =array())
    {
        extract($params);
        if(isset($user_id)&&isset($to_report)&&$to_report)
        {
            $report_arr = array(
                'user_id' =>$user_id,
                'to_report'=>$to_report,
            );
            if(isset($content) && $content)
            {
                $report_arr['content'] = $content;
            }
            if(isset($type) && $type)
            {
                $report_arr['type'] = $type;
            }
            if(isset($style)&&$style)
            {
                $report_arr['style'] = $style;
            }
            $model = new Report();
            $model->attributes=$report_arr;
            if($model->validate() && $model->save())
            {
                $id = $model->getPrimaryKey();
                $ret = $this->notice('OK',0,'成功',['id'=>$id]);
            }else{
                $ret = $this->notice('ERR',307,'数据插入失败',$model->getErrors());
            }
        }else{
            $ret = $this->notice('OK',301,'缺少参数',[]);
        }
        return $ret;
    }
}