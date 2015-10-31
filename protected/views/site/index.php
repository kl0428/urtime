<?php
echo "lll";
/*function foo() {
    $s = 'connection_status '. connection_status();
    mylog($s);
}*/
//register_shutdown_function('foo');//script processing is complete or when exit() is called
/*set_time_limit(10);*/
/*for($i=0; $i<10000000; $i++)
    echo $i;*/


/*function mylog($str)
{
    $cache = Yii::app()->cache_local;
    $str = date('Y-m-d H:i:s').$str."\r\n";
    $cache->lpush('mylog',$str);
}*/
?>

<html>
<body>
<input type="text" id="clock" size="35" />
<!--<input type="text" id="num" size="35" />-->
<p id="num">0</p>
<script language=javascript>
    var int=self.setInterval("clock()",50)
     function clock()
    {
        var t=new Date()

        document.getElementById("clock").value=t
    }
    var n =self.setInterval("num()",1000);
    var i = 0;
    if(i<=60){
        window.onbeforeunload = onbeforeunload_handler;
        window.onunload = onunload_handler;
    }
    function onbeforeunload_handler(){
        var warning="确认退出seo blog?";
        return warning;
    }

    function onunload_handler(){
        var warning="谢谢光临";
        alert(warning);
    }
    function num()
    {
        i++;
        var m = '00';
        var m_s =parseInt(i/60);
        if(m_s)
        {
            if(m_s>=10) {
                m = m_s;
            }else{
                m = '0'+m_s;
            }
        }
        var s = i%60;
        var s_s = '00';
        if(s>=10)
        {
            s_s = s;
        }else{
            s_s = '0'+s;
        }
        document.getElementById("num").innerHTML = m+':'+s_s;
    }
</script>
</form>
<button onclick="int=window.clearInterval(int)">
    Stop interval</button>
<p></p>
<button onclick="n=window.clearInterval(n)">
    Stop num</button>

<script type="text/javascript">
   /* window.onbeforeunload = onbeforeunload_handler;
    window.onunload = onunload_handler;
    function onbeforeunload_handler(){
        var warning="确认退出seo blog?";
        return warning;
    }

    function onunload_handler(){
        var warning="谢谢光临";
        alert(warning);
    }*/
</script>
</body>
</html>


