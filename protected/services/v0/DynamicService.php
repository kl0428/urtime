<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-12-20
 * Time: 下午2:36
 */
class DynamicService extends AppApiService
{
    // 获取关注
    public function focusDynamic($params = array())
    {
        extract($params);

        if (isset($user_id) && $user_id) {

           // $obj = Dynamic::model()->with('focus')->findAll('user_id=:user_id and is_focus=:focus', array(':user_id' => $user_id, ':focus' => '1'));
            $obj = Dynamic::model()->getFocusDynamic($user_id);
            if ($obj) {
                //获取用户信息
                $focus_users = $this->getFocus($user_id);
                $dynamic = array();
                foreach ($obj as $key => $val) {
                    $user_info = $focus_users[$val->focus->focus_id];
                    if ($user_info) {
                        $image = explode(',', $val->dy_images);
                        $images = array();
                        if ($image) {
                            foreach ($image as $k => $v) {
                                $images[] = Yii::app()->params['qiniu']['host'] . $v;
                            }
                        }
                        $dynamic[$key] = array(
                            'id' => $val->dy_id,
                            'content' => $val->dy_content,
                            'images' => $images,
                            'num' => $val->t_agree,
                            'time' => $val->gmt_created,
                        );
                        $dynamic[$key]['logo'] = Yii::app()->params['qiniu']['host'] . $user_info['image'];
                        $dynamic[$key]['nickname'] = $user_info['user_name'];
                    }
                }
                if ($dynamic) {
                    $ret = $this->notice('OK', 0, '成功', $dynamic);
                } else {
                    $ret = $this->notice('OK', 0, '暂无数据', []);
                }
            } else {
                $ret = $this->notice('ERR', 307, '暂无数据', []);
            }

        } else {
            //$ret = $this->notice('ERR', 301, '缺少参数', []);
            $obj = Dynamic::model()->findAll(array('order'=>'gmt_created desc'));
            $dynamic = array();
            if($obj)
            {
                //user
                $users = User::model()->loadUsers();
                $alliances = Alliance::model()->loadAlliances();
                $stores = Store::model()->loadStores();
                foreach ($obj as $key => $val) {
                    if(!$val->dy_type){
                        $user = $users[$val->dy_user];
                        if($user){
                            $dynamic[$key]['logo'] = Yii::app()->params['qiniu']['host'] . $user['image'];
                            $dynamic[$key]['nickname'] = $user['name'];
                        }else{
                            continue;
                        }
                    }else if($val->dy_type==1){
                        $alliance = $alliances[$val->dy_user];
                        if($alliance){
                            $dynamic[$key]['logo'] = Yii::app()->params['qiniu']['host'] . $alliance['image'];
                            $dynamic[$key]['nickname'] = $alliance['name'];
                        }else{
                            continue;
                        }
                    }else if($val->dy_type==2){
                        $store = $stores[$val->dy_user];
                        if($store){
                            $dynamic[$key]['logo'] = Yii::app()->params['qiniu']['host'] . $store['image'];
                            $dynamic[$key]['nickname'] = $store['name'];
                        }else{
                            continue;
                        }
                    }
                    $image = explode(',', $val->dy_images);
                    $images = array();
                    if ($image) {
                        foreach ($image as $k => $v) {
                            $images[] = Yii::app()->params['qiniu']['host'] . $v;
                        }
                    }
                    $dynamic[$key] = array(
                        'id' => $val->dy_id,
                        'content' => $val->dy_content,
                        'images' => $images,
                        'num' => $val->t_agree,
                        'time' => $val->gmt_created,
                    );

                }
                if ($dynamic) {
                    $ret = $this->notice('OK', 0, '成功', $dynamic);
                } else {
                    $ret = $this->notice('OK', 0, '暂无数据', []);
                }
            }else{
                $ret = $this->notice('OK', 0, '暂无数据', []);
            }
        }
        return $ret;
    }

    public function getFocus($user_id = 0)
    {
        if (isset($user_id) && $user_id) {

            $focus_arr = array();
            $cache = Yii::app()->cache;
            if ($focus_users = $cache->get('Focus.User.' . $user_id)) {
                $focus_arr = json_decode($focus_users);
                return $focus_arr;
            } else {
                $focus_user = Focus::model()->with('user')->findAll('user_id=:user_id and focus_type=:type and is_focus=:focus', array(':user_id' => $user_id, ':type' => '0', ':focus' => '1'));
                if ($focus_user) {//个人关注

                    foreach ($focus_user as $key => $val) {
                        $focus_arr[$val->focus_id] = array(
                            'user_name' => $val->user->nickname,
                            'image' => Yii::app()->params['qiniu']['host'] . $val->user->image,
                            'type' => 0,
                        );
                    }

                }
                $focus_alliance = Focus::model()->with('alliance')->findAll('user_id=:user_id and focus_type = :type and is_focus = :focus', array(':user_id' => $user_id, ':type' => '1', ':focus' => '1'));
                if ($focus_alliance) {//联盟关注

                    foreach ($focus_alliance as $key => $val) {
                        $focus_arr[$val->focus_id] = array(
                            'user_name' => $val->alliance->name,
                            'image' => Yii::app()->params['qiniu']['host'] . $val->alliance->image,
                            'type' => 1,
                        );
                    }

                }
                $focus_store = Focus::model()->with('store')->findAll('user_id=:user_id and focus_type = :type and is_focus = :focus', array(':user_id' => $user_id, ':type' => '2', ':focus' => '1'));
                if ($focus_store) {//联盟关注
                    foreach ($focus_store as $key => $val) {
                        $focus_arr[$val->focus_id] = array(
                            'user_name' => $val->store->name,
                            'image' => Yii::app()->params['qiniu']['host'] . $val->store->image,
                            'type' => 2,
                        );
                    }

                }
                if ($focus_arr) {
                    $cache->set(json_encode($focus_arr));
                }

                return $focus_arr;
            }
        }
    }
}