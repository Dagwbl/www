<?php
// 设置返回json格式数据
header('content-type:application/json;charset=utf8');

//连接数据库
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
//查询数据库bak  SensorData表中的内容
$sql = "SELECT sensorid,switch,cmd FROM switches where sensorid = 4";

if ($result = $conn->query($sql)){
    $data = $result->fetch_all();
    echo json_encode($data);
}

$conn->close();


