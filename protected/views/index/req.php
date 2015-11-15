<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-11-3
 * Time: 上午9:07
 */
?>
<div id="main_wrapper">
    <form name="forminput" id="forminput" <?php if($data['action']){?>action="<?=$this->createUrl('index/index',array('debug'=>1))?>"<?php }else{ ?>action="<?=$this->createUrl('index/upImage')?>"<?php }?> method="post" enctype="multipart/form-data">
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

        <?php }else{?>
            image:<input type="file" name="params[file]"/>
            <br/>
            type:<input type="text" name="type" value="banner"/>
        <?php }?>
        <?php //echo  CHtml::image('http://local.urtime.com/assets/images/heard/heard1446549220_7057.png');?>
        <br/>
        <input type="submit" value="提交" />
    </form>
</div>