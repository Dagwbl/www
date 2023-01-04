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
function control($temperature, $sensor): array
{
    global $_db;
    global $logger;
    $result = array();
    $response_level = '';
    if ($temperature >= THIRD_THRESHOLD) {
        // 三级预响应控制数据
        $response_level = 3;
        $control_vex = array(-10, -1, 0, 1, 10);
        $result['message'] = "$sensor reached " . THIRD_THRESHOLD . ". 3-level pr-response started.";
    } elseif ($temperature >= SECOND_THRESHOLD) {
        // 二级预响应控制数组
        $response_level = 2;
        $control_vex = array(-1, 0, 1, 10);
        $result['message'] = "$sensor reached " . SECOND_THRESHOLD . ". 2-level pr-response started.";
    } elseif ($temperature >= FIRST_THRESHOLD) {
        // 一级预响应控制数组
        $response_level = 1;
        $control_vex = array(0);
        $result['message'] = "$sensor reached " . FIRST_THRESHOLD . ". 1-level pr-response started.";
    } elseif ($temperature < RESTORE_THRESHOLD) {
        $response_level = 0;
    } else {
        $control_vex = array();
        $result['message'] = "Monitoring...";
    }
    $sql = "select sensor.node from esp.sensor where model='$sensor'";
    $node = mysqli_fetch_assoc(mysqli_query($_db, $sql))['node'];
    $result['sensor'] = $sensor;
    $result['status'] = 200;
    if ($response_level > 0) {
        // 查询传感器所在的node位置
        $result['ignite node'] = $node;
        foreach ($control_vex as $offset) {
            $nodeId = nodeIdConvert($node) + $offset; // int id 进行offset
//            echo "123:".$nodeId;
            $nodeId = nodeIdConvert($nodeId); // offset 后的 id 转换回 string id
            $sql = "update esp.node set optocouple=1 where coords='$nodeId'";
            mysqli_query($_db, $sql);
            $result['action'][] = $nodeId;
//        echo "$nodeId 已执行控制动作\n";
        }
        $logger::warn(" $node 预响应启动", json_encode($result));
    }else{
        // 查询传感器所在的node位置
        $result['restore node'] = $node;
//        $nodeId = nodeIdConvert($node); // int id 进行offset
//        $nodeId = nodeIdConvert($nodeId); // offset 后的 id 转换回 string id
        $sql = "update esp.node set optocouple=0 where coords='$node'";
        mysqli_query($_db, $sql);
        $result['action'][] = $node;
        $logger::info(" $node restored", json_encode($result));
    }
    return $result;
}

// 下面语句只在模块直接启动时生效
if (realpath(__FILE__)==realpath($_SERVER['SCRIPT_FILENAME'])){
    $result =  control(245,'f1r5-thermocouple-1');
    var_dump($result);

}

