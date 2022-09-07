<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>查询结果</title>
</head>
<body>
<?php

if ($_GET["database"]!="SCD" && $_GET["database"]!="PKU"){
    die("暂时只有SCD和PKU数据库,其他数据库暂未收录");
}

$servername = "localhost";
// 数据库名
$dbname = "ccd";
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
if ($_GET["database"]=="SCD"){
    $sql = "SELECT * from scd where jornal REGEXP '".$_GET["jornal"]."'";
    if ($result = $conn->query($sql)) {
        echo "<h1>查询结果</h1>";
        echo '<table cellspacing="5" cellpadding="5">
          <tr> 
            <td>ID</td> 
            <td>Jornal</td> 
            <td>ISSN</td> 
            <td>CN</td> 
          </tr>';
     
        while ($row = $result->fetch_assoc()) {
            $row_id = $row["id"];
            $row_jornal = $row["jornal"];
            $row_issn = $row["issn"];
            $row_cn = $row["cn"];
          
            echo '<tr> 
                    <td>' . $row_id . '</td> 
                    <td>' . $row_jornal . '</td> 
                    <td>' . $row_issn . '</td> 
                    <td>' . $row_cn . '</td> 
                  </tr>';
        }
        $result->free();
    }
    else {
        echo "There is no matching the query.";
    }


}elseif ($_GET["database"]=="PKU") {
    $sql = "SELECT * from pku where jornal REGEXP '".$_GET["jornal"]."'";
    if ($result = $conn->query($sql)) {
        echo "<h1>查询结果</h1>";
        echo '<table cellspacing="5" cellpadding="5">
          <tr> 
            <td>ID</td> 
            <td>学科门类</td> 
            <td>学科</td> 
            <td>代码</td> 
            <td>分类ID</td> 
            <td>期刊名</td> 
          </tr>';
     
        while ($row = $result->fetch_assoc()) {
            $row_id = $row["id"];
            $row_jornal = $row["jornal"];
            $row_category = $row["category"];
            $row_sub_category = $row["sub_category"];
            $row_code = $row["code"];
            $row_sub_id = $row["sub_id"];
          
            echo '<tr> 
                    <td>' . $row_id . '</td> 
                    <td>' . $row_category . '</td> 
                    <td>' . $row_sub_category . '</td> 
                    <td>' . $row_code . '</td> 
                    <td>' . $row_sub_id . '</td> 
                    <td>' . $row_jornal . '</td> 
                  </tr>';
        }
        $result->free();
    }
    else {
        echo "There is no matching the query.";
    }
}




$conn->close();

echo "</table>";
?>
</body>
</html>