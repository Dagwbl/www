<?php
header("Content-type:application/x-www-form-urlencoded");
header("Access-Control-Allow-Origin:*");
// 设计数据库

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);

// 物端网络数组,用立体的数据结构查询应该更为方便，用二维数组嵌套
$nodes = array(
    array(
        array(1,3,5,7,9),
        array(2,4,6,8,10)
    ),
    array(
        array(1,3,5,7,9),
        array(2,4,6,8,10)
    )
);
echo ($nodes[0][0][1]);
echo "</br>";
// 从data中查询数据库
function query(){
    global $_db;
    $sql = "elect *,MAX(id) from data where sensor like 'thermocouple%' group by sensor;";
    $result = mysqli_query($_db, $sql);
    while ($row = mysqli_query($result)){
        continue;
    }

}