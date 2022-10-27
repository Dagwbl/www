<html lang="zh_CN">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <title>数据库分页测试</title>

</head>
<style>
    body{
        font-size: 12px;
        font-family: Verdana, serif;
        background-color: beige;
    }
    .container{
        display: flex;
        width: 100%;
    }
    .left{
        width: 150px;
        margin-left: 20px;
        background-color: antiquewhite;
    }
    .nav{
        margin-top: 20px;
        height: 30px;
        font-size: larger;
        text-align: center;
        /*background-color: lightsteelblue;*/
    }
    .right{
        flex: 1;
        width: 100%;
        height: 90%;
        /*display: flex;*/
        background-color: bisque;

    }
    h1{
        text-align: center;
    }
    div.content{
        height: 95%;
    }
    div.page{
        height: 10%;
        /*margin-bottom: 20px;*/
        text-align: center;
        padding-top: 20px;
    }
    div.page a{
        border: #808080 1px solid;text-decoration: none;padding: 2px 5px 2px 5px;margin: 5px;
    }
    div.page span.current{
        border: cadetblue 1px solid;background-color: cadetblue;padding:3px 6px 3px 6px;margin: 5px;color: #fff;
        font-weight: bold;
    }
    div.page span.disable{
        border: grey 1px solid;padding: 2px 5px 2px 5px;margin: 5px;color: grey;
    }
    div.page form{
        display: inline;
    }
    table {
        border: 1px solid;
        width: 100%;
        cellspacing: 0;
        align: center;
    }
    tr td{
        text-align: center;
        border: 1px solid;
    }
    tr{
        /*font-weight: bold;*/
        border: 1px solid;
    }
    td{
        font-size: small;
        /*border: 1px solid;*/
    }

</style>
<body>
<?php
require_once './config/db.php';
require_once './config/profile.php';

echo "<h1>MariaDB数据库浏览——传感器数据</h1>";

echo "<div class='container'>";
echo "<div class='left'>";
echo "<div class='nav'>";
    echo "<a  href='layout/component/node.html'>物端列表</a>";
echo "</div>";
echo "<div class='nav'>";
    echo "<a href='layout/component/sensor.html'>喷头状态</a>";
echo "</div>";
echo "<div class='nav'>";
    echo "<a href='manualcontrol.php'>手动控制</a>";
echo "</div>";
echo "<div class='nav'>";
    echo "<a href='experiment.php'>实验测试</a>";
echo "</div>";
echo "</div>";


echo "<div class='right'>";
// 传入页码
$page = $_GET['p'];
// 根据页码取出数据php-MySQL

// connect database
$_db = connectDatabase(HOST, USERNAME, PASSWORD, DBNAME);
// 显示数据和分页条
mysqli_select_db($_db,DBNAME);
$page_size = 45;
$sql = "SELECT * FROM `bak`.sensordata LIMIT " . ($page-1) * $page_size ." ,$page_size";
echo "<div class='content'>";
$result = mysqli_query($_db,$sql);
echo "<table>";
echo "<tr style='font-weight: bold;background-color: #313335;color: #f2f2f2'><td>id</td><td>data</td><td>sensor</td><td>temperature</td><td>humidity</td><td>probetime</td><td>verify</td></tr>";
while ($row = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo  "<td>{$row['id']}</td>";
    echo  "<td>{$row['sensor']}</td>";
    echo  "<td>{$row['coords']}</td>";
    echo  "<td>{$row['temperature']}</td>";
    echo  "<td>{$row['humidity']}</td>";
    echo  "<td>{$row['probetime']}</td>";
    echo  "<td>{$row['verify']}</td>";
    echo "<tr>";
}
echo "</table>";
echo "</div>";


mysqli_free_result($result);
//获取总数
$total_sql = "select count(*) from `bak`.sensordata";
$total_result = mysqli_fetch_array(mysqli_query($_db,$total_sql));
$total = $total_result[0];
//echo "总条数".$total;
$total_pages = ceil($total/$page_size);
mysqli_close($_db);
//存放分页条
$page_banner = '';
//显示中间的5页
$show_page = 5;


$page_offset = ($show_page-1)/2;
$start_page = 1;
$end_page = $total_pages;
$page_banner = "<div class='page'>";
if ($page>1){
    $page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=".(1)."'>首页</a>";
    $page_banner .= "<a href='".$_SERVER['PHP_SELF']."?p=".($page-1)."'><上一页</a>";
}else{
    $page_banner .= "<span class='disable'>首页</span>";
    $page_banner .= "<span class='disable'>第一页</span>";
}
if ($total_pages>$show_page){
    if ($page>$page_offset+1){
        $page_banner .= '...';
    }
    if ($page>$page_offset){
        $start_page = $page-$page_offset;
        $end_page = $total_pages > $page+$page_offset?$page+$page_offset:$total_pages;
    }else{
        $start_page=1;
        $end_page = $total_pages>$show_page?$show_page:$total_pages;

    }
    if ($page+$page_offset>$total_pages){
        $start_page = $start_page-($page+$page_offset-$end_page);

    }
}
// 计算了起始位置之后，将其显示
for ($i = $start_page;$i<=$end_page;$i++){
    if ($page==$i){
        $page_banner.="<span class='current'>{$i}</span>";//当前页不用点击所以不用添加其他的。
//        $page_banner.= "<a href='".$_SERVER['PHP_SELF']."?p=".($i)."'>{$i}</a>";
    }else{
        $page_banner.= "<a href='".$_SERVER['PHP_SELF']."?p=".($i)."'>{$i}</a>";
    }
}
if ($page<$total_pages){
    $page_banner .= '...';
    $page_banner.= "<a href='".$_SERVER['PHP_SELF']."?p=".($page+1)."'>下一页></a>";
    $page_banner.= "<a href='".$_SERVER['PHP_SELF']."?p=".($total_pages)."'>尾页</a>";

}

//尾部省略
if ($total_pages>$show_page&&$total_pages>$page+$page_offset){
//    $page_banner .= '...';
//    $page_banner.= "第{$page}页";
    $page_banner.= "  共{$total_pages}页  ";
}else{
    $page_banner .= "<span class='disable'>下一页</span>";
    $page_banner .= "<span class='disable'>尾页</span>";
}

$page_banner .= "<form action='index.php' method='get'>";
$page_banner .= "到第 <input type='text' size='2' name='p'> 页 ";
$page_banner .= "<input type=submit value='确定'>";
$page_banner .= "</form>";
$page_banner .= "</div>";
$page_banner .= "</div>";
$page_banner .= "</div>";

echo $page_banner;
?>
</body>
</html>