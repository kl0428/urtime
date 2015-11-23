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
        if(isset($nickname) && isset($password)){
            //查询手机是否注册过
            $user = User::model()->exists(array('condition'=>'mobile=:mobile','params'=>array(':mobile'=>isset($mobile)?$mobile:0)));
            if(!$user){
                $result = array(
                    'nickname'=>$nickname,
                    'sex'=>isset($sex)?$sex:0,
                    'mobile'=>isset($mobile)?$mobile:0,
                    'image'=>isset($image)?$image:'',
                    'password'=>md5($mobile.md5($password)),
                );
                $model = new User();
                $model->attributes=$result;
                if($model->validate()&&$model->save())
                {
                    $ret = $this->notice('OK', 0, '', $result);
                }else{
                    $ret = $this->notice('ERR', 307, '', ['val']);
                }

            }else{
                $ret = $this->notice('ERR', 306, '该号码已经注册过了', ['val']);
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
                        'username' => $user->username
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
                        $ret = $this->notice('OK',0,array('pwd'=>$new_pwd));
                    };
                }else{
                    $ret = $this->notice('ERR',309,array('error'=>serliaize($user)));
                }
            }else{
                $ret = $this->notice('ERR',301,array('code'=>$code,'save_code'=>$save_code));
            }
            return $ret;
        }
    }

    //添加关注
    public function addFocus($params = array())
    {
        extract($params);
        if(isset($focus_user)&&$focus_user&&isset($user_id)&&$user_id)
        {
            $focus = array(
                'focus_user' =>$focus_user,
                'user_id'    =>$user_id,
            );
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
            $focus = Focus::model()->with('user')->findAll('user_id=:user_id and is_focus = :focus',array(':user_id'=>$user_id,'is_focus'=>'1'));
            if($focus){
                $focus_arr = array();
                foreach($focus as $key=>$val)
                {
                    $focus_arr[] = array(
                        'user_name' =>$val->user->nickname,
                        'image' =>$val->user->image,
                    );
                }
                $result = $focus_arr;
                $ret = $this->notice('OK',0,'成功',$result);
            }else{
                $ret = $this->notice('OK',0,'成功',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
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