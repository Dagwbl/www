<?php
// sensor表样式
/*
| id   | node | model          | parameter   | upload |
| ---- | ---- | -------------- | ----------- | ------ |
| 1    | 1    | ds18b20-1      | temperature | 1      |
| 2    | 2    | lm35-1         | humidity    | 1      |
| 3    | 7    | PMS7003-1      | pm          | 1      |
| 4    | 7    | opt101-1       | illuminance | 1      |
| 5    | 7    | thermocouple-1 | temperature | 1      |
*/
header("Content-type:application/x-www-form-urlencoded");
header("Access-Control-Allow-Origin:*");
// 设计数据库

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);
//$_db->query("set data utf8");
// 构建接口
// 返回的数据对象
$opj_db = 'esp';
$opj_table =  "sensor";  //本文件主要操作esp.sensor表
$sql = "";
//$result = "";
$res = array();
if (isset($_GET['action'])){
    $action=$_GET['action'];
    $coords=$_POST['coords'];
    //查询数据
    if ($action=='query'){
        if (isset($_GET['p'])){
            $page = $_GET['p'];
            $page_size = 20;
            $sql = "SELECT * FROM `$opj_db`.$opj_table LIMIT " . ($page-1) * $page_size ." ,$page_size";
        }else{
            $sql = "SELECT * FROM `$opj_db`.$opj_table WHERE coords='$coords'";
        }
        $result = mysqli_query($_db,$sql);
        while ($row = mysqli_fetch_assoc($result)){
            $res[] = $row;
        }

    }
    // 插入数据
    elseif ($action=='insert'){
//        $data = $_POST['data'];
        var_dump($_POST);
//        echo $_POST;
        $value =$_POST['value'];
        $unit = $_POST['unit'];
        $sensor =$_POST['sensor'];
        $raw =$_POST['raw'];
        $verify =$_POST['verify'];

        $sql = "INSERT INTO $opj_db.$opj_table (value, unit, sensor, time, `raw`, verify) VALUES ($value, '$unit','$sensor', DEFAULT, '$raw', '$verify')";
        echo $sql;
        $result = mysqli_query($_db,$sql);
        if ($result){
            $res["message"] = "insert successfully";
        }else{
            $res["error"]=true;
            $res["message"]="insert failed";
        }
    }
    // 删除数据
    elseif ($action=='delete'){
        $id = $_POST['id'];
//        $data = $_POST['data'];
        $sql = "DELETE FROM $opj_db.$opj_table WHERE `id`='$id'";
        $result = mysqli_query($_db,$sql);
        if ($result==1){
            echo "hahds";
            echo $result;
            $res["message"] = "delete successfully";
        }else{
            $res["error"]=true;
            $res["message"]="delete failed";
        }
    }
    // 更新数据
    elseif ($action=='update'){
        #$id = $_POST['id'];
        $coords = $_POST['coords'];
        $opt_status = $_POST['optocouple'];
        $sql = "UPDATE $opj_db.$opj_table SET optocouple=$opt_status WHERE `coords`='$coords'";
        echo $sql;
        $result = mysqli_query($_db,$sql);
        if ($result){
            $res["message"] = "update successfully";
        }else{
            $res["error"]=true;
            $res["message"]="update failed";
        }
    }

}


mysqli_close($_db);

echo json_encode($res);
//echo "hah";
die();


