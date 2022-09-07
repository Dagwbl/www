<?php
header("Content-type:application/x-www-form-urlencoded");
header("Access-Control-Allow-Origin:*");
// 设计数据库

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);

// 物端网络数组,用立体的数据结构查询应该更为方便，用二维数组嵌套
//$nodes = array(
//    array(
//        array(1,3,5,7,9),
//        array(2,4,6,8,10)
//    ),
//    array(
//        array(1,3,5,7,9),
//        array(2,4,6,8,10)
//    )
//);
// 生成房间数组
$generateArray = function (int $idx_floor,int $idx_room) {
    $nodes = Array();
    for ($f=1;$f<=$idx_floor;$f++){
        for ($r=1;$r<=$idx_room;$r++){
            if ($r%2==1) {
                $nodes[$f][0][] = $r;
            }
            else {
                $nodes[$f][1][] = $r;
            }
        }
    }
    return $nodes;
};

//监测查询函数
$monitor = function () use ($_db) {
    // 从data中查询数据库
    $sql = "select *,MAX(id) from data where sensor like 'thermocouple%' group by sensor;";
    //下面这条sql语句联合了三个表，可以获得所有的信息，包括传感器信息和物端节点信息
    $sql = "select *,MAX(d.id) from data d inner join sensor s on d.sensor = s.model inner join node n on s.node = n.id where d.sensor like 'thermocouple%' group by sensor";
    $result = mysqli_query($_db, $sql);
    while ($row = mysqli_fetch_assoc($result)){
        print_r($row);
    }
};

//计算函数，返回需要控制的房间
$analysis = function (int $ignite_location,int $pre_level){

    return $control_vex;
};

// 启动入口
$run = function () use ($monitor, $generateArray) {
    //链接数据库
    $nodes = $generateArray(10,10);
    $anti_shake = 0;
    if ($monitor()){
        $anti_shake += 1;
        if ($anti_shake==2){
            //执行控制

            $anti_shake = 0; //执行完毕继续开启防抖
        }

    };
//    var_dump($nodes);
};

$run();
echo "</br>";

