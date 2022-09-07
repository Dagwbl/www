<?php
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

$sensor = 'sensor1';
$coords = 'xy';
$value1 = 'value1';
$value2 = 'value2';
$value3 = 'value3';
$id     = 123;

$sql = "INSERT INTO SensorData (id, sensor, coords, value1, value2, value3) VALUES ('$id','$sensor', '$coords', '$value1', '$value2', '$value3')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>