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

$api_key = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $read_post = file_get_contents('php://input');
    $datas = json_decode($read_post, true);

    $api_key = $datas['api_key'];

    if ($api_key == $api_key_value) {
//        echo $datas;
        // setting PDO Mode 
        

        // $conn = new mysqli($servername, $username, $password, $dbname);
        $conn = new PDO('mysql:host='.$servername.';dbname='.$dbname,$username,$password,[PDO::ATTR_PERSISTENT=>true]);
        // 检查数据库连接状态
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }

        $sql = "INSERT INTO `experiment1` (`seq`, `vin`, `lm35dz`, `thermcouple`, `probetime`,`flag`) VALUES (:seq,:vin,:lm35dz, :thermcouple, :probetime,:flag)";
        $sm = $conn->prepare($sql);

        $sm->bindParam(':seq',$datas['seq']);
        $sm->bindParam(':vin',$datas['vin']);
        $sm->bindParam(':lm35dz',$datas['lm35dz']);
        $sm->bindParam(':thermcouple',$datas['thermcouple']);
        $sm->bindParam(':probetime',$datas['probetime']);
        $sm->bindParam(':flag',$datas['flag']);

        // $seq     = (int)$datas['seq'];
        // $lm35dz = $datas['lm35dz'];
        // $thermcouple = $datas['thermcouple'];
        // $probetime = $datas['probetime'];
        // $flag = $datas['flag'];
        // $vin = $datas['vin'];
        if (!$sm->execute()){
            throw new Exception("insert fail",101);
        }

        // if ($conn->query($sql) === TRUE) {
        //     echo "\nNew record created successfully\n";
        // } else {
        //     echo "Error: " . $sql . "<br>" . $conn->error;
        // }

        return [
            'dbid'=>$conn->lastInsertId(),  
            'time'=>time(),
        ];

    } else {
        echo $read_post;
        var_dump(json_last_error_msg());
        echo "Wrong API Key provided.<br/>";
    }
} else {
    echo "No data posted with HTTP POST.<br/>";
}
