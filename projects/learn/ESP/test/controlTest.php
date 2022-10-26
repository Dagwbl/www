<?php

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
require_once '../utils/tools.php';
$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);



/**
 * 控制函数
 * @param $temperature
 * @param $sensor
 * @return array|int[]
 */
function control($temperature, $sensor): array
{
    global $_db;
    if ($temperature > THIRD_THRESHOLD){
        // 三级预响应控制数据
        $control_vex = array(-10,-1,0,1,10);
        echo "检测到传感器 $sensor 温度达到 ".THIRD_THRESHOLD." 已启动三级预响应\n";
    }elseif ($temperature>SECOND_THRESHOLD){
        // 二级预响应控制数组
        $control_vex = array(-1,0,1);
        echo "检测到传感器 $sensor 温度达到 ".SECOND_THRESHOLD." 已启动二级预响应\n";
    }elseif ($temperature > FIRST_THRESHOLD){
        // 一级预响应控制数组
        $control_vex = array(0);
        echo "检测到传感器 $sensor 温度达到 ".SECOND_THRESHOLD." 已启动一级响应\n";
    }else{
        $control_vex = array();
        echo "无异常情况，持续监测中...";
    }

    // 查询传感器所在的node位置
    $sql = "select sensor.node from esp.sensor where model='$sensor'";
    $node = mysqli_fetch_assoc(mysqli_query($_db,$sql))['node'];
    foreach ($control_vex as $offset){
        $nodeId = nodeIdConvert($node)+$offset; // int id 进行offset
        $nodeId = nodeIdConvert($nodeId); // offset 后的 id 转换回 string id
        $sql = "update node set optocouple=1 where coords='$nodeId'";
        mysqli_query($_db, $sql);
        echo "$nodeId 已执行控制动作\n";
    }

    return $control_vex;

}

control(0,'testsensor-3');
