<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Control Panel</title>
</head>

<body>
    <h1>Control Panel</h1>
    <div class="navigate">
        <div class="navigateItem">File</div>
        <div class="navigateItem">Databases</div>
        <div class="navigateItem">Refresh</div>
        <div class="navigateItem">System Status</div>
    </div>

    <div class="mainPanel">
        <div class="sensorRTDataFrame">
            <div>
                Real-time Sensor Data
            </div>
            <div>-----------------</div>
            <div class="sensorData">
                <!-- put the sensor data here-->
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
                $sql = "SELECT id, sensor, coords, temperature, humidity, probetime, verify FROM SensorData ORDER BY verify DESC LIMIT 30";

                echo '<table cellspacing="5" cellpadding="5" style="font-size:12;">
                <tr> 
                    <th>ID</th> 
                    <th>Sensor</th> 
                    <th>Coords</th> 
                    <th>Temperature</th> 
                    <th>Humidity</th>
                    <th>Probetime</th> 
                    <th>Verify</th> 
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
                // echo ("<script type=\"text/javascript\">");
                // echo ("function fresh_page()");
                // echo ("{");
                // echo ("window.location.reload();");
                // echo ("}");
                // echo ("setTimeout('fresh_page()',3000);"); //3秒刷新一次
                // echo ("</script>");

                ?>
                </table>
            </div>
        </div>

        <div class="sensorListFrame">
            <div>
                Sensor List
            </div>
            <div>---------------------</div>
            <div>
                <!-- Put the sensor list here -->
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
                };
                $sql = "SELECT sensorid, model,coords,mark from sensorlist ORDER BY sensorid limit 20";
                echo "<table border='0'>
                <tr>
                <th>ID</th>
                <th>Model</th>
                <th>Coords</th>
                <th>Status</th>
                </tr>
                ";
                if ($result = $conn->query($sql)){
                    while ($row=$result->fetch_assoc()) {
                        $row_id = $row["sensorid"];
                        $row_model = $row["model"];
                        $row_coords = $row["coords"];
                        $row_mark = $row["mark"];
                    
                        echo '<tr> 
                        <td>' . $row_id . '</td> 
                        <td>' . $row_model . '</td> 
                        <td>' . $row_coords . '</td> 
                        <td>' . $row_mark . '</td> 
                      </tr>';
                    
                    }
                    $result->free();
                }
                $conn->close()
                ?>
            </div>

        </div>

    </div>

</body>

</html>