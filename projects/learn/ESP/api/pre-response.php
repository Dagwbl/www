<?php
header("Content-type:application/x-www-form-urlencoded");
header("Access-Control-Allow-Origin:*");
// 设计数据库

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
$_db = connectDatabase(HOST, USERNAME, PASSWORD, DBNAME);


// 基础参数配置
const FIRST_THRESHOLD = 70;
const SECOND_THRESHOLD = 300;

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
$generateArray = function (int $idx_floor, int $idx_room) {
    $nodes = array();
    for ($f = 1; $f <= $idx_floor; $f++) {
        for ($r = 1; $r <= $idx_room; $r++) {
            if ($r % 2 == 1) {
                $nodes[$f][0][] = $r;
            } else {
                $nodes[$f][1][] = $r;
            }
        }
    }
    return $nodes;
};

//监测查询函数 TODO 这里还没有处理好数据
$monitor = function () use ($_db) {

    // 从data中查询数据库
    $sql = "select *,MAX(id) from data where sensor like 'thermocouple%' group by sensor;";
    //下面这条sql语句联合了三个表，可以获得所有的信息，包括传感器信息和物端节点信息
    $sql = "select *,MAX(d.id) from data d inner join sensor s on d.sensor = s.model inner join node n on s.node = n.id where d.sensor like 'thermocouple%' group by sensor";
    //上面这条查询语句比较消耗性能，常规查询语句，只需要查询温度值超过阈值的节点温度就好了,只能先查询再判断
    $sql = "select * from ($sql) where value>70";
    $result = mysqli_query($_db, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        print_r($row);
    }
};

//计算函数，返回需要控制的房间位置坐标以及预响应等级
$analysis = function (string $ignite_location, int $pre_level) {
    //设房间坐标为[i][j][k]，通过
    // 1 3 5
    // 2 4 6
    // 可以得到其与fnrm的中m的转化关系为，m = (k+1)(j+1)
    // 上一步得到的房间号应为数据库里面的房间号，因此需要分别计算出i,j,k
    // 2r4c2 通过正则表达式分解为如下数组
    //    Array
    //    (
    //        [0] =>
    //        [1] => 2
    //        [2] => 4
    //        [3] => 2
    //     )
    $chars = preg_split('/[frct]/', $ignite_location);
    $i = $chars[1];
    $j = $chars[2] % 2 ? 0 : 1;
    $k = $chars[2]/($j+1)-1;
    $coords = array($i,$j,$k,$pre_level);
    print_r($chars);
    print_r($coords);

    return $coords;
};
$analysis('f2r4c2', 1);

//执行控制动作
$execAction = function (int $ignite_location, $control_vex) {
    foreach ($control_vex as $offset) {

    }
};

//重置开关状态
$reset_opt = function (int $flag = 0) use ($_db) {
    if ($flag) {
        $sql = "update esp.node n set n.optocouple=1 where n.optocouple is not null";
        $result = mysqli_query($_db, $sql);
        echo "全部光耦状态已置1";
    } else {
        $sql = "update esp.node n set n.optocouple=0 where n.optocouple is not null";
        $result = mysqli_query($_db, $sql);
        echo "全部光耦状态已置0";
    }

};

// 启动入口
$run = function () use ($monitor, $generateArray) {
    // 预响应阈值设置

    //链接数据库
    $nodes = $generateArray(10, 10);
    $anti_shake = 0;
    if ($monitor()) {
        $anti_shake += 1;
        if ($anti_shake == 2) {
            //执行控制

            $anti_shake = 0; //执行完毕继续开启防抖
        }

    };
//    var_dump($nodes);
};

$run();
echo "</br>";

