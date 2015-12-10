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
            code:<input type="text" name="params[code]" value="654321">
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
            leader:<input type="text" name="params[user_id]" value="6"> <br/>
            <!--name:<input type="text" name="params[name]" value="健身"/> <br/>
            alliance:<input type="text" name="params[alliance_id]" value="1"><br/>-->
            <!--notice:<input type="text" name="params[notice]" value="2015-11-25日火星救援上映"><br/>-->
            <!--leader:<input type="text" name="params[user_id]" value="1">-->
        <?php }elseif($data['action']=='getAlliances'){?>
            alliance:<input type="text" name="params[alliance_id]" value="1"><br/>

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
        <?php }elseif($data['action']=='deleteDynamic'){?>
            id:<input type="text" name="params[id]" value=""/> 动态id(必填)<br/>
        <?php }else{?>
            image:<input type="file" name="upImage"/>
            <br/>
            image2:<input type="file" name="upImage2"/>
        <?php }?>
        <?php //echo  CHtml::image('http://local.urtime.com/assets/images/heard/heard1446549220_7057.png');?>
        <br/>
        <input type="submit" value="提交" />
    </form>
</div>