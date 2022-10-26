<?php

/**
 * @author Dagwbl
 *
 * 主函数
    预响应逻辑需要好好想清楚然后再进行代码的编写
    响应操作的核心是对数据库进行持续的动态操作
    1.一个不间断运行的循环函数
    2.数据持续进行监测
    3.如果有数据发生异常则进入响应控制函数

 */

//设置header
header("Content-type:application/x-www-form-urlencoded");
header("Access-Control-Allow-Origin:*");


// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
$_db = connectDatabase(HOST, USERNAME, PASSWORD, DBNAME);

/**
物端网络数组,用立体的数据结构查询应该更为方便，用二维数组嵌套
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
*/


/**
 * 生成房间数组
 *
 * @param int $idx_floor
 * @param int $idx_room
 * @return array
 */
function generateArray(int $idx_floor, int $idx_room): array
{
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


/**
 * 监测函数
 *
 * @return void
 * @todo 这里还没有处理好数据
 * @todo 查询函数有重新设计
 */
function monitor(): void
{
    global $_db;
    $sql = "select *,MAX(id) from data where sensor like 'thermocouple%' group by sensor"; // 从data中查询数据库
    //下面这条sql语句联合了三个表，可以获得所有的信息，包括传感器信息和物端节点信息
    $sql = "select *,MAX(d.id) from data d inner join sensor s on d.sensor = s.model inner join node n on s.node = n.id where d.sensor like 'thermocouple%' group by sensor";
    //上面这条查询语句比较消耗性能，常规查询语句，只需要查询温度值超过阈值的节点温度就好了,只能先查询再判断
    $sql = "select * from esp.data where value>70";
    $result = mysqli_query($_db, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        print_r($row);
    }
};

/**
 * 计算函数，返回需要控制的房间的位置坐标以及预响应等级
 * @param string $ignite_location
 * @param int $pre_level
 * @return array
 */
function analysis(string $ignite_location, int $pre_level): array
{
    /**
    设房间坐标为[i][j][k]，通过
     1 3 5
     2 4 6
     可以得到其与fnrm的中m的转化关系为，m = (k+1)(j+1)
     上一步得到的房间号应为数据库里面的房间号，因此需要分别计算出i,j,k
     2r4c2 通过正则表达式分解为如下数组
        Array
        (
            [0] =>
            [1] => 2
            [2] => 4
            [3] => 2
         )
     */
    $chars = preg_split('/[frct]/', $ignite_location);
    $i = $chars[1];
    $j = $chars[2] % 2 ? 0 : 1;
    $k = $chars[2]/($j+1)-1;
    $coords = array($i,$j,$k,$pre_level);
    print_r($chars);
    print_r($coords);

    return $coords;
};
analysis('f2r4c2', 1);


/**
 * 控制方法选择，暂时只设置常规方法
 * @param string $method
 * @return array
 */
function controlMethod(string $method='normal'):array
{
    global $_db;
    if ($method=='normal'){
        $control_vex = array();
    }

    return $control_vex;
};

//执行控制动作
$execAction = function (int $ignite_location, $control_vex) {
    foreach ($control_vex as $offset) {
    continue;
    }
};


/**
 * 重置光耦开关状态
 * @param int $flag
 * @return void
 */
function reset_opt(int $flag = 0):void
{
    global $_db;
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


/**
 * 响应控制入口函数
    1.获取异常数据相应的坐标
    2.根据编号规则或者数据结构获取周围房间的数据
    3.根据异常数据的响应等级进行分别控制(如何控制是关键)
    4.控制同时生成报告和发送警报信息
    5.结束
 * @todo    防抖功能    自动执行（后台运行）
 */
function run(): void
{

    $nodes = generateArray(10, 10); //生成node数组
    var_dump($nodes);
    while (true){
        sleep(3);
        monitor();
    }
};

// 启动
run();


