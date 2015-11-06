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
            new_pwd:<input type="text" name="params[newpwd]" value="1235678">
            <br/>
            code:<input type="text" name="params[code]" value="kmsfu2">
        <?php }elseif($data['action'] == 'sendSms'){?>
            mobile:<input type="text" name="params[mobile]" value="18368113211"/>
            <br/>
            type:<input type="text" name="params[type]" value="register"/>
        <?php }else{?>
            image:<input type="file" name="params[file]"/>
        <?php }?>
        <br/>
        <input type="submit" value="提交" />
    </form>
</div>