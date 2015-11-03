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
            username:<input type="text" name="params[username]"  value="zhaoqing@lamahui.com" />
            </br>
            password:<input type="text" name="params[password]"  value="zhaoqing" />
            </br>
        <?php }elseif($data['action']=='login'){?>
            username:<input type="text" name="params[username]"  value="zhaoqing@lamahui.com" />
            </br>
            password:<input type="text" name="params[password]"  value="zhaoqing" />
            </br>
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