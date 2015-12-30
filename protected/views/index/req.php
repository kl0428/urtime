<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-11-3
 * Time: 上午9:07
 */
?>
<div id="main_wrapper">
    <form name="forminput" id="forminput" <?php if($data['action']){?>action="<?=$this->createUrl('index/index',array('debug'=>1))?>"<?php }else{ ?>action="<?=$this->createUrl('image/upImages')?>"<?php }?> method="post" enctype="multipart/form-data">
            app_key:<input type="text" name="app_key" value="<?=$data['app_key'] ?>"/>
            </br>
            method :<input type="text" name="method" value="<?=$data['method']?>"/>
            </br>
            timestamp :<input type="text" name="timestamp" value="<?=$data['timestamp']?>"/>
            </br>
            app_sign:<input type="text" name="app_sign" value="<?=$data['app_sign']?>"/>
            </br>

        <?php if($data['action']=='register'){?>
            image:<input type="text" name="params[image]" value="heard1446549220_7057.png"/>
            </br>
            sex:<input type="text" name="params[sex]" value="0"/>
            </br>
            nickname:<input type="text" name="params[nickname]" value="test"/>
            </br>
            password:<input type="text" name="params[password]" value="123456">
            </br>
            mobile:<input type="text" name="params[mobile]" value="18368113211">
            </br>
            code:<input type="text" name="params[code]" value="FqyYj8">
        <?php }elseif($data['action']=='findEmchatGroup'){?>
            name:<input type="text" name="params[name]"  value="test" />
            </br>
        <?php }elseif($data['action']=='getEmchatToken'){?>
              token:<input type="text" name="params[token]"  value="urtime" />
              </br>
        <?php }elseif($data['action']=='addEmchatUser'){?>
            name:<input type="text" name="params[name]"  value="test" />
            </br>
            pwd:<input type="text" name="params[pwd]"  value="123456" />
            </br>
        <?php }elseif($data['action']=='createEmchatGroup'){?>
            groupname:<input type="text" name="params[groupname]"  value="test" />
            </br>
            owner:<input type="text" name="params[owner]"  value="zhaoqing" />
            </br>
            desc:<input type="text" name="params[desc]" value="测试群"/>
        <?php }elseif($data['action']=='changeEmchatGroup'){?>
            id:<input type="text" name="params[id]"  value="1" />
            </br>
            desc:<input type="text" name="params[desc]"  value="测试群2" />
            </br>
            name:<input type="text" name="params[name]" value="测试群"/>
        <?php }elseif($data['action']=='emchatGroupUsers'){?>
            group_id:<input type="text" name="params[group_id]"  value="142612998723207616" />
            </br>
            type:<input type="text" name="params[type]"  value="add" />添加:add删除delete获取所有 get
            </br>
            username:<input type="text" name="params[username]" value="test"/>
        <?php }elseif($data['action']=='getEmchatList'){?>
            type:<input type="text" name="params[type]"  value="group" />
            </br>
        <?php }elseif($data['action']=='login'){?>
            username:<input type="text" name="params[username]"  value="18368113211" />
            </br>
            password:<input type="text" name="params[password]"  value="123456" />
            </br>
        <?php }else if($data['action']=='forget'){?>
            mobile:<input type="text" name="params[mobile]" value="18368113211">
            <br/>
            new_pwd:<input type="text" name="params[newpwd]" value="12345678">
            <br/>
            code:<input type="text" name="params[code]" value="Ty2PZI">
        <?php }elseif($data['action'] == 'sendSms'){?>
            mobile:<input type="text" name="params[mobile]" value="18368113211"/>
            <br/>
            type:<input type="text" name="params[type]" value="register"/>
        <?php }elseif($data['action'] == 'banner'){?>
        <?php }elseif($data['action'] == 'cards'){?>
            key:<input type="text" name="params[key]" value="1">
        <?php }elseif($data['action'] == 'cardInfo'){?>
            type_id:<input type="text" name="params[type_id]" value="0">
            <br/>
            num:<input type="text" name="params[num]"value="1">
        <?php }elseif($data['action']=='city'){?>
            provice:<input type="text" name="params[provice]" value="31"/>
        <?php }elseif($data['action']=='alliance'){?>
            name:<input type="text" name="params[name]" value="健身"/> <br/>
            center_name:<input type="text" name="params[center_name]" value="健身中心"> <br/>
            image:<input type="text" name="params[image]" value="http://local.urtime.com/assets/images/heard/heard1446549220_7057.png"> <br/>
            user_id:<input type="text" name="params[user_id]" value="6"> <br/>
            <!--name:<input type="text" name="params[name]" value="健身"/> <br/>
            alliance:<input type="text" name="params[alliance_id]" value="1"><br/>-->
            <!--notice:<input type="text" name="params[notice]" value="2015-11-25日火星救援上映"><br/>-->
            <!--leader:<input type="text" name="params[user_id]" value="1">-->
        <?php }elseif($data['action']=='getAlliances'){?>
            alliance_id:<input type="text" name="params[alliance_id]" value="1"><br/>

        <?php }elseif($data['action']=='cities'){?>

        <?php }elseif($data['action']=='provice'){?>
        <?php }elseif($data['action']=='pay'){?>
            channel:<input type="text" name="params[channel]" value="alipay_wap"/>付款方式 <br/>
            amount:<input type="text" name="params[amount]" value="1"> 金额<br/>
            subject:<input type="text" name="params[subject]" value="Urtime"> <br/>
            body:<input type="text" name="params[body]" value="你在Urtime购买了本产品"> <br/>
            user_id:<input type="text" name="params[user_id]" value="1">用户id <br/>
            store_id:<input type="text" name="params[store_id]" value="1">店铺id选填 <br/>
            flag:<input type="text" name="params[flag]" value="1">1-卡,2-课程 <br/>
            content:<input type="text" name="params[content]" value="1">卡号或课程 <br/>
        <?php }elseif($data['action']=='addFocus'){?>
            user_id:<input type="text" name="params[user_id]" value=""/> <br/>
            focus_user:<input type="text" name="params[focus_user]" value=""/> <br/>
        <?php }elseif($data['action']=='delFocus'){?>
            focus_id:<input type="text" name="params[focus_id]" value=""/> <br/>
            user_id:<input type="text" name="params[user_id]" value=""/> <br/>
        <?php }elseif($data['action']=='getFocus'){?>
            user_id:<input type="text" name="params[user_id]" value=""/> <br/>
        <?php }elseif($data['action']=='report'){?>
            user_id:<input type="text" name="params[user_id]" value=""/><br/>
            to_report:<input type="text" name="params[to_report]" value=""/> <br/>
            content:<input type="text" name="params[content]" value=""/> <br/>
            type:<input type="text" name="params[type]" value=""/> 0-用户,1-联盟<br/>
            style:<input type="text" name="params[style]" value=""/> 0-举报,1-反馈<br/>
        <?php }elseif($data['action']=='addDynamic'){?>
            id:<input type="text" name="params[id]" value=""/> id<br/>
            type:<input type="text" name="params[type]" value=""/> 动态类型 0-个人 1-联盟 2-店铺 3-其他<br/>
            content:<input type="text" name="params[content]" value=""/> <br/>
            image:<input type="text" name="params[image]" value=""/> json格式<br/>
        <?php }elseif($data['action']=='getDynamic'){?>
            id:<input type="text" name="params[id]" value=""/> id(传入获取指定联盟动态/空获取所有)<br/>
            type:<input type="text" name="params[type]" value=""/> 动态类型 0-个人 1-联盟 2-店铺 3-其他(必填)<br/>
            user_id:<input type="text" name="params[user_id]" value=""/>user_id<br/>
        <?php }elseif($data['action']=='deleteDynamic'){?>
            id:<input type="text" name="params[id]" value=""/> 动态id(必填)<br/>
        <?php }elseif($data['action']=='getDetailDynamic'){?>
            id:<input type="text" name="params[id]" value=""/> id(动态id)<br/>
            user_id:<input type="text" name="params[user_id]" value="">当前用户id<br/>
        <?php }elseif($data['action']=='update'){?>
            id:<input type="text" name="params[id]" value=""/> id(用户)<br/>
            nickname:<input type="text" name="params[nickname]" value="png"/>
            </br>
            username:<input type="text" name="params[username]" value="heardg"/>
            </br>
            image:<input type="text" name="params[image]" value="heard1446549220_7057.png"/>
            </br>
            sex:<input type="text" name="params[sex]" value="0"/>
            </br>
            province:<input type="text" name="params[province]" value="1"/>
            </br>
            mobile:<input type="text" name="params[mobile]" value="18368113211">
            </br>
            email:<input type="text" name="params[email]" value="123@qq.com">
            </br>
            city:<input type="text" name="pagrams[city]" value="23">
            </br>
         <?php }elseif($data['action']=='user'){?>
            id:<input type="text" name="params[id]" value=""/> id(用户id)<br/>
        <?php }elseif($data['action']=='agree'){?>
            id:<input type="text" name="params[id]" value=""/> id(动态id)<br/>
            user_id:<input type="text" name="params[user_id]" value="">当前用户id<br/>
        <?php }elseif($data['action']=='addComment'){?>
            dynamic_id:<input type="text" name="params[dynamic_id]" value=""/> id(动态id)<br/>
            user_id:<input type="text" name="params[user_id]" value=""/> id(用户id)<br/>
            content:<input type="text" name="params[content]" value=""/> 评论内容<br/>
            images:<input type="text" name="params[images]" value=""/> 图片<br/>
        <?php }elseif($data['action']=='getComment'){?>
            dynamic_id:<input type="text" name="params[dynamic_id]" value=""/> id(动态id)<br/>
        <?php }elseif($data['action']=='sendSmsByCCP'){?>
            to:<input type="text" name="params[to]" value="18368113211"/> <br/>
            tempId:<input type="text" name="params[tempId]" value="1"/><br/>
        <?php }elseif($data['action']=='emchat'){?>
            channel:<input type="text" name="params[channel]" value="44"/> <br/>
        <?php }elseif($data['action']=='focusDynamic'){?>
            $user_id:<input type="text" name="params[user_id]" value="123"/> <br/>
        <?php }else{?>
            upImage:<input type="file" name="upImage"/>
            <br/>
            upImage2:<input type="file" name="upImage2"/>
        <?php }?>
        <?php //echo  CHtml::image('http://local.urtime.com/assets/images/heard/heard1446549220_7057.png');?>
        <br/>
        <input type="submit" value="提交" />
    </form>
</div>