<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 15-12-20
 * Time: 上午11:38
 */
class EmchatService extends AppApiService
{

    //获取token
    public function getEmchatToken($params=array())
    {
        extract($params);
        Yii::import("application.extensions.Emchat.*");
        $h=new Easemob();
        $token=$h->getToken();
        if($token){
            $ret= $this->notice('OK',0,'成功',['token'=>$token]);
        }else{
            $ret=$this->notice('ERR',307,'获取失败',[]);
        }
        return $ret;
    }

    //创建单个用户
    public function addEmchatUser($params=array())
    {
        extract($params);
        Yii::import("application.extensions.Emchat.*");
        $h=new Easemob();
        if(isset($name)&&$name){
            $pwd = isset($pwd)?$pwd:'123456';
            $res=$h->createUser($name,$pwd);
        }
        if($res){
            $ret= $this->notice('OK',0,'成功',$res);
        }else{
            $ret=$this->notice('ERR',307,'获取失败',[]);
        }
        return $ret;
    }

    //创建群组
    public function createEmchatGroup($params=array())
    {
        extract($params);
        if(isset($groupname)&&$groupname&&isset($owner)&&$owner){
            Yii::import("application.extensions.Emchat.*");
            $h=new Easemob();
            $options ['groupname'] = $groupname;
            $options ['desc'] = (isset($desc)&&$desc)?$desc:"this is a love group";
            $options ['public'] = true;
            $options ['owner'] = $owner;
            $group = $h->createGroup($options);
            if($groupid=$group['data']['groupid']){
                $groups = array(
                    'name'=>$groupname,
                    'owner'=>$owner,
                    'desc'=>(isset($desc)&&$desc)?$desc:"this is a love group",
                    'emchat_id'=>$groupid
                );
                $emchat = new Emchat();
                $emchat->attributes = $groups;
                if($emchat->validate()&&$emchat->save()){
                    $ret = $this->notice('OK',0,'成功',$groups);
                }else{
                    $ret = $this->notice('ERR',307,'操作失败',$emchat->getErrors());
                }
            }else{
                $ret = $this->notice('ERR',306,'操作失败',$group);
            }

        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
       return $ret;

    }

    //修改群组
    public function changeEmchatGroup($params=array())
    {
        extract($params);
        if(isset($id)&&$id){
            Yii::import("application.extensions.Emchat.*");
            $h=new Easemob();
            $model = new Emchat();
            $emchat = $model->findByPk($id);
            $emchat_arr =array();
            $emchat_group = array();
            $emchat_id = $emchat->emchat_id;
            if(isset($name)&&$name)
            {
                $emchat_arr['name']=$name;
                $emchat_group['groupname']=$name;
            }
            if(isset($desc)&&$desc)
            {
                $emchat_arr['desc']=$desc;
                $emchat_group['description']=$desc;
            }
            $emchat_group['maxusers'] = 300;
            if($emchat_arr){
                $emchat->attributes=$emchat_arr;
                if($emchat->validate()&&$emchat->save()){
                    $res =$h->modifyGroupInfo($emchat_id,$emchat_group);
                    $ret = $this->notice('OK',0,'成功',$res);
                }else{
                    $ret = $this->notice('ERR',307,'操作失败',$emchat->getErrors());
                }
            }else{
                $ret = $this->notice('ERR',304,'没有可修改数据',[]);
            }
        }else{
            $ret = $this->notice('ERR',301,'缺少参数',[]);
        }
          return $ret;
    }

    //添加群成员
    public function emchatGroupUsers($params=array())
    {
        extract($params);
        if(isset($group_id)&&$group_id&&isset($type)&&$type)
        {
            Yii::import("application.extensions.Emchat.*");
            $h=new Easemob();
            if($type=='add' && isset($username)&&$username){
                $usernames['usernames']=array($username);
                $res = $h->addGroupMembers($group_id,$usernames);
                if($res['data']){
                    $ret= $this->notice('OK',0,'成功',$res['data']);
                }else{
                    $ret= $this->notice('ERR',306,'获取数据失败',$res);
                }
            }else if($type=='delete'&&isset($username)&&$username)
            {
                $usernames['usernames']=array($username);
               $res =  $h->deleteGroupMembers($group_id,$usernames);
                if($res['data']){
                    $ret= $this->notice('OK',0,'成功',$res['data']);
                }else{
                    $ret= $this->notice('ERR',306,'获取数据失败',$res);
                };
            }else if($type=='get')
            {
                $res =  $h->getGroupUsers($group_id);
                if($res['data']){
                    $ret= $this->notice('OK',0,'成功',$res['data']);
                }else{
                    $ret= $this->notice('ERR',306,'获取数据失败',$res);
                }
            }
        }else{
            $ret =$this->notice('ERR',301,'缺少参数',[]);
        }
        return $ret;
    }

    public function getEmchatList($params=array()){
         extract($params);
        $model = Emchat::model()->findAll();
        $emchats = array();
        if($model)
        {
            foreach($model as $key=>$val)
            {
                $emchats[]=array(
                    'id'=>$val->id,
                    'name'=>$val->name,
                    'desc'=>$val->desc,
                    'group_id'=>$val->emchat_id,
                    'created'=>$val->gmt_created,
                );
            }
            $ret= $this->notice('OK',0,'成功',$emchats);

        }else{
            $ret= $this->notice('ERR',306,'获取数据失败',[]);
        }
        return $ret;
    }




    public function emchat($params = array())
    {
        extract($params);
        Yii::import("application.extensions.Emchat.*");
        $h=new Easemob();

        //$i=70;
        if(isset($channel)&&$channel){
            $c = $channel;
        }else{
            $c = 44;
        }
        switch($c){
            case 10://获取token
                $token=$h->getToken();
                var_dump($token);
                break;
            case 11://创建单个用户
                var_dump($h->createUser("zhangsan","123456"));
                break;
            case 12://创建批量用户
                var_dump($h->createUsers(array(
                    array(
                        "username"=>"zhangsan",
                        "password"=>"123456"
                    ),
                    array(
                        "username"=>"lisi",
                        "password"=>"123456"
                    )
                )));
                break;
            case 13://重置用户密码
                var_dump($h->resetPassword("zhangsan","123456"));
                break;
            case 14://获取单个用户
                var_dump($h->getUser("zhangsan"));
                break;
            case 15://获取批量用户---不分页(默认返回10个)
                var_dump($h->getUsers());
                break;
            case 16://获取批量用户----分页
                $cursor=$h->readCursor("userfile.txt");
                var_dump($h->getUsersForPage(10,$cursor));
                break;
            case 17://删除单个用户
                var_dump($h->deleteUser("zhangsan"));
                break;
            case 18://删除批量用户
                var_dump($h->deleteUsers(2));
                break;
            case 19://修改昵称
                var_dump($h->editNickname("zhangsan","小B"));
                break;
            case 20://添加好友------400
                var_dump($h->addFriend("zhangsan","lisi"));
                break;
            case 21://删除好友
                var_dump($h->deleteFriend("zhangsan","lisi"));
                break;
            case 22://查看好友
                var_dump($h->showFriends("zhangsan"));
                break;
            case 23://查看黑名单
                var_dump($h->getBlacklist("zhangsan"));
                break;
            case 24://往黑名单中加人
                $usernames=array(
                    "usernames"=>array("wangwu","lisi")
                );
                var_dump($h->addUserForBlacklist("zhangsan",$usernames));
                break;
            case 25://从黑名单中减人
                var_dump($h->deleteUserFromBlacklist("zhangsan","lisi"));
                break;
            case 26://查看用户是否在线
                var_dump($h->isOnline("zhangsan"));
                break;
            case 27://查看用户离线消息数
                var_dump($h->getOfflineMessages("zhangsan"));
                break;
            case 28://查看某条消息的离线状态
                var_dump($h->getOfflineMessageStatus("zhangsan","77225969013752296_pd7J8-20-c3104"));
                break;
            case 29://禁用用户账号----
                var_dump($h->deactiveUser("zhangsan"));
                break;
            case 30://解禁用户账号-----
                var_dump($h->activeUser("zhangsan"));
                break;
            case 31://强制用户下线
                var_dump($h->disconnectUser("zhangsan"));
                break;
            case 32://上传图片或文件
                var_dump($h->uploadFile("./resource/up/pujing.jpg"));
                //var_dump($h->uploadFile("./resource/up/mangai.mp3"));
                //var_dump($h->uploadFile("./resource/up/sunny.mp4"));
                break;
            case 33://下载图片或文件
                var_dump($h->downloadFile('01adb440-7be0-11e5-8b3f-e7e11cda33bb','Aa20SnvgEeWul_Mq8KN-Ck-613IMXvJN8i6U9kBKzYo13RL5'));
                break;
            case 34://下载图片缩略图
                var_dump($h->downloadThumbnail('01adb440-7be0-11e5-8b3f-e7e11cda33bb','Aa20SnvgEeWul_Mq8KN-Ck-613IMXvJN8i6U9kBKzYo13RL5'));
                break;
            case 35://发送文本消息
                $from='admin';
                $target_type="users";
                //$target_type="chatgroups";
                $target=array("zhangsan","lisi","wangwu");
                //$target=array("122633509780062768");
                $content="Hello HuanXin!";
                $ext['a']="a";
                $ext['b']="b";
                var_dump($h->sendText($from,$target_type,$target,$content,$ext));
                break;
            case 36://发送透传消息
                $from='admin';
                $target_type="users";
                //$target_type="chatgroups";
                $target=array("zhangsan","lisi","wangwu");
                //$target=array("122633509780062768");
                $action="Hello HuanXin!";
                $ext['a']="a";
                $ext['b']="b";
                var_dump($h->sendCmd($from,$target_type,$target,$action,$ext));
                break;
            case 37://发送图片消息
                $filePath="./resource/up/pujing.jpg";
                $from='admin';
                $target_type="users";
                $target=array("zhangsan","lisi");
                $filename="pujing.jpg";
                $ext['a']="a";
                $ext['b']="b";
                var_dump($h->sendImage($filePath,$from,$target_type,$target,$filename,$ext));
                break;
            case 38://发送语音消息
                $filePath="./resource/up/mangai.mp3";
                $from='admin';
                $target_type="users";
                $target=array("zhangsan","lisi");
                $filename="mangai.mp3";
                $length=10;
                $ext['a']="a";
                $ext['b']="b";
                var_dump($h->sendAudio($filePath,$from="admin",$target_type,$target,$filename,$length,$ext));
                break;
            case 39://发送视频消息
                $filePath="./resource/up/sunny.mp4";
                $from='admin';
                $target_type="users";
                $target=array("zhangsan","lisi");
                $filename="sunny.mp4";
                $length=10;//时长
                $thumb='https://a1.easemob.com/easemob-demo/chatdemoui/chatfiles/c06588c0-7df4-11e5-932c-9f90699e6d72';
                $thumb_secret='wGWIyn30EeW9AD1fA7wz23zI8-dl3PJI0yKyI3Iqk08NBqCJ';
                $ext['a']="a";
                $ext['b']="b";
                var_dump($h->sendVedio($filePath,$from="admin",$target_type,$target,$filename,$length,$thumb,$thumb_secret,$ext));
                break;
            case 40://发文件消息
                break;
            case 41://获取app中的所有群组-----不分页（默认返回10个）
                var_dump($h->getGroups());
                break;
            case 42:////获取app中的所有群组--------分页
                $cursor=$h->readCursor("groupfile.txt");
                var_dump($h->getGroupsForPage(2,$cursor));
                break;
            case 43://获取一个或多个群组的详情
                $group_ids=array("1445830526109","1445833238210");
                var_dump($h->getGroupDetail($group_ids));
                break;
            case 44://创建一个群组
                $options ['groupname'] = "group001";
                $options ['desc'] = "this is a love group";
                $options ['public'] = true;
                $options ['owner'] = "zhaoqing";
                $options['members']=Array("fengpei","lisi");
                var_dump($h->createGroup($options));
                break;
            case 45://修改群组信息
                $group_id="124113058216804760";
                $options['groupname']="group002";
                $options['description']="修改群描述";
                $options['maxusers']=300;
                var_dump($h->modifyGroupInfo($group_id,$options));
                break;
            case 46://删除群组
                $group_id="124113058216804760";
                var_dump($h->deleteGroup($group_id));
                break;
            case 47://获取群组中的成员
                $group_id="122633509780062768";
                var_dump($h->getGroupUsers($group_id));
                break;
            case 48://群组单个加人------
                $group_id="122633509780062768";
                $username="lisi";
                var_dump($h->addGroupMember($group_id,$username));
                break;
            case 49://群组批量加人
                $group_id="122633509780062768";
                $usernames['usernames']=array("wangwu","lisi");
                var_dump($h->addGroupMembers($group_id,$usernames));
                break;
            case 50://群组单个减人
                $group_id="122633509780062768";
                $username="test";
                var_dump($h->deleteGroupMember($group_id,$username));
                break;
            case 51://群组批量减人-----
                $group_id="122633509780062768";
                $usernames['usernames']=array("wangwu","lisi");
                var_dump($h->deleteGroupMembers($group_id,$usernames));
                break;
            case 52://获取一个用户参与的所有群组
                var_dump($h->getGroupsForUser("zhangsan"));
                break;
            case 53://群组转让
                $group_id="122633509780062768";
                $options['newowner']="lisi";
                var_dump($h->changeGroupOwner($group_id,$options));
                break;
            case 54://查询一个群组黑名单用户名列表
                $group_id="122633509780062768";
                var_dump($h->getGroupBlackList($group_id));
                break;
            case 55://群组黑名单单个加人-----
                $group_id="122633509780062768";
                $username="lisi";
                var_dump($h->addGroupBlackMember($group_id,$username));
                break;
            case 56://群组黑名单批量加人
                $group_id="122633509780062768";
                $usernames['usernames']=array("lisi","wangwu");
                var_dump($h->addGroupBlackMembers($group_id,$usernames));
                break;
            case 57://群组黑名单单个减人
                $group_id="122633509780062768";
                $username="lisi";
                var_dump($h->deleteGroupBlackMember($group_id,$username));
                break;
            case 58://群组黑名单批量减人
                $group_id="122633509780062768";
                $usernames['usernames']=array("wangwu","lisi");
                var_dump($h->deleteGroupBlackMembers($group_id,$usernames));
                break;
            case 59://创建聊天室
                $options ['name'] = "chatroom001";
                $options ['description'] = "this is a love chatroom";
                $options ['maxusers'] = 300;
                $options ['owner'] = "zhangsan";
                $options['members']=Array("man","lisi");
                var_dump($h->createChatRoom($options));
                break;
            case 60://修改聊天室信息
                $chatroom_id="124121390293975664";
                $options['name']="chatroom002";
                $options['description']="修改聊天室描述";
                $options['maxusers']=300;
                var_dump($h->modifyGroupInfo($chatroom_id,$options));
                break;
            case 61://删除聊天室
                $chatroom_id="124121390293975664";
                var_dump($h->deleteChatRoom($chatroom_id));
                break;
            case 62://获取app中所有的聊天室
                var_dump($h->getChatRooms());
                break;
            case 63://获取一个聊天室的详情
                $chatroom_id="124121939693277716";
                var_dump($h->getChatRoomDetail($chatroom_id));
                break;
            case 64://获取一个用户加入的所有聊天室
                var_dump($h->getChatRoomJoined("zhangsan"));
                break;
            case 65://聊天室单个成员添加--
                $chatroom_id="124121939693277716";
                $username="zhangsan";
                var_dump($h->addChatRoomMember($chatroom_id,$username));
                break;
            case 66://聊天室批量成员添加
                $chatroom_id="124121939693277716";
                $usernames['usernames']=array('wangwu','lisi');
                var_dump($h->addChatRoomMembers($chatroom_id,$usernames));
                break;
            case 67://聊天室单个成员删除
                $chatroom_id="124121939693277716";
                $username="zhangsan";
                var_dump($h->deleteChatRoomMember($chatroom_id,$username));
                break;
            case 68://聊天室批量成员删除
                $chatroom_id="124121939693277716";
                $usernames['usernames']=array('zhangsan','lisi');
                var_dump($h->deleteChatRoomMembers($chatroom_id,$usernames));
                break;
            case 69://导出聊天记录-------不分页
                $ql="select+*+where+timestamp>1435536480000";
                var_dump($h->getChatRecord($ql));
                break;
            case 70://导出聊天记录-------分页
                $ql="select+*+where+timestamp>1435536480000";
                $cursor=$h->readCursor("chatfile.txt");
                //var_dump($h->$cursor);
                var_dump($h->getChatRecordForPage($ql,10,$cursor));
                break;
        }
        
    }
}
