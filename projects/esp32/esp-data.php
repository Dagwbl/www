<!DOCTYPE html>
<html><body>
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

//查询数据库bak  SensorData表中的内容
$sql = "SELECT id, sensor, coords, temperature, humidity, probetime, verify FROM SensorData ORDER BY verify DESC LIMIT 50";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>Sensor</td> 
        <td>Coords</td> 
        <td>Temperature</td> 
        <td>Humidity</td>
        <td>Probetime</td> 
        <td>Verify</td> 
      </tr>';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_sensor = $row["sensor"];
        $row_coords = $row["coords"];
        $row_temperature = $row["temperature"];
        $row_humidity = $row["humidity"]; 
        $row_probetime = $row["probetime"]; 
        $row_verify = $row["verify"];
      
        echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_sensor . '</td> 
                <td>' . $row_coords . '</td> 
                <td>' . $row_temperature . '</td> 
                <td>' . $row_humidity . '</td>
                <td>' . $row_probetime . '</td> 
                <td>' . $row_verify . '</td> 
              </tr>';
    }
    $result->free();
}

$conn->close();

//<!--JS 页面自动刷新 -->
echo ("<script type=\"text/javascript\">");
echo ("function fresh_page()"); 
echo ("{");
echo ("window.location.reload();");
echo ("}"); 
echo ("setTimeout('fresh_page()',3000);"); //3秒刷新一次
echo ("</script>");

?> 
</table>
</body>
</html>
