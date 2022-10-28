<?php

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
require_once '../utils/tools.php';
require_once 'log.php';


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
    if ($temperature > THIRD_THRESHOLD){
        // 三级预响应控制数据
        $response_level = 'THIRD';
        $control_vex = array(-10,-1,0,1,10);
        $result['message'] = "The temperature $sensor reaches ".THIRD_THRESHOLD.". The third level pr-response has been started.";
    }elseif ($temperature>SECOND_THRESHOLD){
        // 二级预响应控制数组
        $response_level = 'SECOND';
        $control_vex = array(-1,0,1);
        $result['message'] = "The temperature $sensor reaches ".SECOND_THRESHOLD.". The second level pr-response has been started.";
    }elseif ($temperature > FIRST_THRESHOLD){
        // 一级预响应控制数组
        $response_level = 'FIRST';
        $control_vex = array(0);
        $result['message'] =  "The temperature $sensor reaches ".SECOND_THRESHOLD.". The first level pr-response has been started.";
    }else{
        $control_vex = array();
        $result['message'] = "Everything's fine, Continuous monitoring...";
    }

    if ($response_level<>''){
        // 查询传感器所在的node位置
        $sql = "select sensor.node from esp.sensor where model='$sensor'";
        $node = mysqli_fetch_assoc(mysqli_query($_db,$sql))['node'];
        $result['sensor'] = $sensor;
        $result['status'] = 200;
        $result['ignite node'] = $node;
        foreach ($control_vex as $offset){
            $nodeId = nodeIdConvert($node)+$offset; // int id 进行offset
            $nodeId = nodeIdConvert($nodeId); // offset 后的 id 转换回 string id
            $sql = "update node set optocouple=1 where coords='$nodeId'";
            mysqli_query($_db, $sql);
            $result['action'][] = $nodeId;
//        echo "$nodeId 已执行控制动作\n";
        }
        $logger::warn(" $node 预响应启动",json_encode($result));
    }

    return $result;

}

// 下面语句只在模块直接启动时生效
if (realpath(__FILE__)==realpath($_SERVER['SCRIPT_FILENAME'])){
    $result =  control(330,'testsensor-3');
    var_dump($result);

}

