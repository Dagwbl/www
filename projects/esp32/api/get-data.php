<?php
header("Access-Control-Allow-Origin:*");//解决跨域请求问题
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with, content-type');
header("content-Type: text/html; charset=utf-8");//字符编码设置

$servername = "localhost";
$username = "root";
$password = "1005";
$dbname = "bak";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // 设置 PDO 错误模式，用于抛出异常
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM sensordata ORDER BY probetime DESC LIMIT 50;";
    // 使用 exec() ，没有结果返回
    $stmt = $conn->query($sql)->fetchAll();
//    $stmt = $conn->query($sql)->fetch(PDO::FETCH_OBJ);
//    var_dump($stmt);
    echo json_encode($stmt,JSON_UNESCAPED_UNICODE);
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}