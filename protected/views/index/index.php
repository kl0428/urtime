<?php
/**
 * Created by PhpStorm.
 * User: gongxiaohong
 * Date: 15-6-19
 * Time: 下午1:27
 */

echo "<h1>PHP QR Code</h1><hr/>";
?>
<!--<html>
<head>
    <title>打印不同图形</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
</head>
<body  bgcolor="#C7EDCC">

<?php
/*$row = @$_REQUEST['row'];//加@是为了消除一开始页面没有输入数据的notice提示
$col = @$_REQUEST['col'];
$shape = @$_REQUEST['shape'];

function printShape($row,$col,$shape)
{
    switch ($shape)
    {
        case 'a':
            for ($i=1;$i<$row;$i++)
            {
                for ($j=0;$j<$col;$j++)
                    echo "*";
                echo "<br/>";
            }
            break;

        case 'b':
            for ($i=1;$i<$row;$i++)
            {
                for ($j=0;$j<$i;$j++)
                    echo "*";
                echo "<br/>";
            }
            break;

        case 'c':
            for ($i=1;$i<$row;$i++)
            {
                for ($k=0;$k<$col-$i;$k++)
                    echo "&nbsp";
                for ($j=0;$j<2*$i-1;$j++)
                    echo "*";
                // for ($k=0;$k<round(($col-$i)/2);$k++)
                // echo " ";
                echo "<br/>";
            }
            break;

        case 'd':
            for ($i=1;$i<=$row;$i++)
            {
                for ($k=0;$k<$col-$i;$k++)
                    echo "&nbsp";
                if ($i==1 || $i==$row)//第一行和最后一行不用控制
                {
                    for ($j=1;$j<=2*$i-1;$j++)
                        echo "*";
                    echo "<br/>";
                }
                else
                {
                    for ($j=1;$j<=2*$i-1;$j++)
                    {
                        if ($j==1 || $j==2*$i-1 )
                            echo "*";
                        else
                            echo "&nbsp";
                    }
                    echo "<br/>";
                }
            }
            break;

        default:
            echo "您没有输入图形";
            break;
    }

}
*/?>


<form action="<?/*=$this->createUrl('index/index')*/?>" method="post">
    <span>请输入打印的行数:</span><br/><input type="text" name="row" value="<?php /*echo $row*/?>"/><br/>
    <span>请输入打印的列数:</span><br/><input type="text" name="col" value="<?php /*echo $col*/?>"/><br/>
    <span>请输入打印的图形(a -- 矩形  b -- 半三角 c -- 实心金字塔 d--空心金字塔 ):</span><br/>
    <select name="shape">
        <option value='a'>矩形</option>
        <option value='b'>半三角形</option>
        <option value='c'>实金字塔</option>
        <option value='d'>空心金字塔</option>
    </select>
    <input type="submit" value="提交打印"/>
</form>

<?php /*printShape($row,$col,$shape)*/?>

</body>
</html>-->


<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script language="javascript">
        function printdiv(printpage){
            var headstr="<html><head><title></title></head><body>";
            var footstr="</body>";
            var newstr=document.all.item(printpage).innerHTML;
            var oldstr=document.body.innerHTML;
            document.body.innerHTML=headstr+newstr+footstr;
            window.print();
            document.body.innerHTML=oldstr;
            return false;
        }
    </script>
    <title>div print</title>
</head>
<body>
<input type="button" onClick="printdiv('div_print');" value=" 打印 ">
<div id="div_print">
    <h1 style="Color:Red">被打印区域：www.phpernote.com</h1>
</div>
这块区域是打印不到的！
</body>
</html>
