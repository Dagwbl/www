<?php

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
require_once '../utils/tools.php';
require_once '../utils/log.php'; // 存在同名文件需要相对路径定位回父级目录再定位回来


$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);
$logger = new log();


/**
 * 控制函数
 * 为了方便接口调试，所有交互数据采用英文编码
 * @param $temperature
 * @param $sensor
 * @return array|int[]
 */
function control($temperature, $sensor, $coords): array
{
    global $_db;
    global $logger;
    $result = array();
    $response_level = '';
    $sqls = array();
    if ($temperature >= THIRD_THRESHOLD) {
        // 三级预响应控制，走廊全部喷水，竖向通道喷水
        $response_level = 3;
//        $control_vex = array(array(0,0.5),array(0,2.5),array(0,4.5),array(0,6.5),array(0,8.5));
        $sqls = array(
            "update esp.node set optocouple=1 where coords like 'f2r_.5';",
            "update esp.node set optocouple=1 where coords like 'f9r_';");
        $result['level'] = $response_level;
        $result['action'][]='aisle';
    } elseif ($temperature >= SECOND_THRESHOLD) {
        // 二级预响应控制，周围喷水
        $response_level = 2;
        $control_vex = array(array(-1,0),array(1,0),array(0,1),array(0,2),array(0,-1),array(0,-2));
        foreach ($control_vex as $vex){
            $chars = preg_split('/[frct]/', $coords);
            $tmp = 'f'.($chars[1]+$vex[0]).'r'.($chars[2]+$vex[1]);
            $result['action'][] = $tmp;
            $sqls[] = "update esp.node set optocouple=1 where coords='$tmp'";
//            var_dump($chars);
        }
        $result['level'] = $response_level;
    } elseif ($temperature >= FIRST_THRESHOLD) {
        // 一级预响应控制，自身房间喷水，走廊外一个喷水
        $response_level = 1;
        $control_vex = array(array(0,0),array(0,0.5));
        foreach ($control_vex as $vex){
            $chars = preg_split('/[frct]/', $coords);
            $tmp = 'f'.($chars[1]+$vex[0]).'r'.($chars[2]+$vex[1]);

            $result['action'][] = $tmp;
            $sqls[] = "update esp.node set optocouple=1 where coords='$tmp'";
        }
        $result['level'] = $response_level;
    } elseif ($temperature < RESTORE_THRESHOLD && !str_contains($coords,'.')) {
        // 小于恢复温度自动关闭
        $response_level = 0;
        $sqls[] = "update esp.node se  t optocouple=0 where coords='$coords'";
        $result['restored'] = true;
    }
    // 执行动作
    foreach ($sqls as $sql){
        mysqli_query($_db,$sql);
    }
//    $sql = "select sensor.node from esp.sensor where model='$sensor'";
//    $node = mysqli_fetch_assoc(mysqli_query($_db, $sql))['node'];
    $result['coords']=$coords;
    $result['sensor'] = $sensor;
    $result['status'] = 200;
    if ($response_level > 0 && SPRAY_FLAG){
        $logger::warn($coords.', T:'.$temperature.', L:'.$response_level,json_encode($result));
    }elseif ($response_level==0 && RESTORE_FLAG){
        $logger::info($coords.', T:'.$temperature.', L:'.$response_level,json_encode($result));
    }


//    if ($response_level > 0) {
//        // 查询传感器所在的node位置
//        $result['ignite node'] = $node;
//        foreach ($control_vex as $offset) {
//            $nodeId = nodeIdConvert($node) + $offset; // int id 进行offset
////            echo "123:".$nodeId;
//            $nodeId = nodeIdConvert($nodeId); // offset 后的 id 转换回 string id
//            if (SPRAY_FLAG){
//                $sql = "update esp.node set optocouple=1 where coords='$nodeId'";
//                mysqli_query($_db, $sql);
//            }
//            $result['action'][] = $nodeId;
////        echo "$nodeId 已执行控制动作\n";
//        }
//        $logger::warn(" $node 预响应启动", json_encode($result));
//    }elseif($response_level==0 && RESTORE_FLAG){
//        // 查询传感器所在的node位置
//        $result['restore node'] = $node;
////        $nodeId = nodeIdConvert($node); // int id 进行offset
////        $nodeId = nodeIdConvert($nodeId); // offset 后的 id 转换回 string id
//        $sql = "update esp.node set optocouple=0 where coords='$node'";
//        mysqli_query($_db, $sql);
//        $result['action'][] = $node;
//        $logger::info(" $node restored", json_encode($result));
//    }
    return $result;
}

// 下面语句只在模块直接启动时生效
if (realpath(__FILE__)==realpath($_SERVER['SCRIPT_FILENAME'])){
    $result =  control(80,'f2r1-thermocouple-1','f2r3');
    var_dump($result);
}

