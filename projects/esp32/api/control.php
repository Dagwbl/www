
<?php
//header('Content-Type:aplication/json');
$servername = "localhost";
// 数据库名
$dbname = "bak";
// 数据库用户名
$username = "root";
// 数据库密码
$password = "1005";
// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检查数据库连接状态
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 执行控制指令
$sw_id = $_POST["switchID"];
$exe_cmd = $_POST["cmd"];

if ($sw_id and ($exe_cmd==0 or $exe_cmd==1)){
    $update_sql = "UPDATE switches SET cmd='".$exe_cmd."' WHERE switch='".$sw_id."'";
    echo "\r\n";
    echo $update_sql;
    echo "<br/>";
    if ($update_info=$conn->query($update_sql)){
        echo "\n指令执行成功";
    }
    else{
        echo "\n指令执行不成功";
    }


}
else{
    echo $sw_id;
    echo "<br/>";
    echo $exe_cmd;
    echo "\n指令未执行\n\n";
}


//查询数据库bak  SensorData表中的内容
$sensor_id=4;
$sql = "SELECT sensorid,switch,cmd FROM switches where sensorid = 4";

if ($result = $conn->query($sql)) {
    # TODO It may be optimized here.
    $json_data = $result->fetch_all();
    $json['total'] = count($json_data); 
    $json['rows'] = $json_data;
    echo "<br/>";
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    while ($row = $result->fetch_assoc()) {
        $row_sensor_id = $row["sensorid"];
        $row_switch = $row["switch"]; 
        $row_cmd = $row["cmd"];
        if ($row["cmd"]==0){
            $switch_status="off";
        }
        else{
            $switch_status="on";
        }
        echo "\nThe switch: (".$row_switch.") at the coordinate: (".$row_sensor_id.") current status is ".$switch_status.".\n";
        
    }
    $result->free();
}
else{
    echo "\n No corresponding switch was found!\n";
}

$conn->close();
