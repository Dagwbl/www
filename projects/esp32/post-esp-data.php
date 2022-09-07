<?php

$servername = "localhost";  //数据库地址
// 数据库名
$dbname = "bak";
// 数据库用户名
$username = "root";
// 数据库密码
$password = "1005";

//保持此API密钥值与项目页面中提供的ESP32代码兼容。
//如果您更改此值，则ESP32草图需要匹配
$api_key_value = "tPmAT5Ab3j7F9";

$api_key = $sensor = $coords = $temperature = $humidity = $verify = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $read_post = file_get_contents('php://input');
    $datas = json_decode($read_post, true);

    $api_key = $datas['api_key'];

    if ($api_key == $api_key_value) {
        echo $datas;
        // setting PDO Mode 
        $conn = new mysqli($servername, $username, $password, $dbname);
        // 检查数据库连接状态
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sensor = $datas['sensor'];
        $coords = $datas['coords'];
        $temperature = $datas['temperature'];
        $humidity = $datas['humidity'];
        $verify = $sensor.'-'.$coords.'-'.(string)time();
        $id     = (int)$datas['id'];
        $probetime = $datas['probetime'];
        echo "\nverify  $verify\n";
        // $sql = "INSERT INTO sensordata ( id, sensor, coords, temperature, humidity, verify,reading_time)
        //     VALUES ('$id','$sensor', '$coords', '$temperature', '$humidity', '$verify')";
        $sql = "INSERT INTO sensordata (id, sensor, coords, temperature, humidity, probetime,verify) VALUES ('$id','$sensor', '$coords', '$temperature', '$humidity', '$probetime','$verify')";
        if ($conn->query($sql) === TRUE) {
            echo "\nNew record created successfully\n";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Wrong API Key provided.<br/>";
    }
} else {
    echo "No data posted with HTTP POST.<br/>";
}
