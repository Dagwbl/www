<?php
/* 样表
| id   | value | unit | sensor    | time                  | raw                                              | verify     |
| ---- | ----- | ---- | --------- | --------------------- | ------------------------------------------------ | ---------- |
| 737  | 17    |      | PMS7003-1 | 2022-09-01 11:38:34.0 | 424d01c0110180200110180209752ac08e01706009703ab  | L435T72191 |
| 738  | 57    |      | PMS7003-1 | 2022-09-01 11:38:37.0 | 424d01c05605e06303904004f31e9fc009301204009705b3 | L435T74706 |
| 739  | 78    |      | PMS7003-1 | 2022-09-01 11:38:39.0 | 424d01c07707e08104e05305c4665164c08b0b020097055a | L435T77447 |
| 740  | 111   |      | PMS7003-1 | 2022-09-01 11:38:42.0 | 424d01c0a90b10b406f07507662791f470980c0202970693 | L435T80081 |
*/

// 目前只适配了插入功能，其他功能勿用
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
//$opj_table =  "data";  //本文件主要操作esp.data表
$sql = "";
//$result = "";
$res = array();
if (isset($_GET['action'])){
    $action=$_GET['action'];
    //查询数据
    if ($action=='query'){
        if (isset($_GET['p'])){
            $page = $_GET['p'];
            $page_size = 20;
            $sql = "SELECT * FROM `esp`.data LIMIT " . ($page-1) * $page_size ." ,$page_size";
        }else{
            $sql = "SELECT * FROM `esp`.data";

        }
        $result = mysqli_query($_db,$sql);
        while ($row = mysqli_fetch_assoc($result)){
            $res[] = $row;
        }

    }
    // 插入数据
    elseif ($action=='insert'){
//        $data = $_POST['data'];
//        var_dump($_POST);
//        echo $_POST;
        $value =$_POST['value'];
        $unit = $_POST['unit'];
        $sensor =$_POST['sensor'];
        $raw =$_POST['raw'];
        $verify =$_POST['verify'];

        $sql = "INSERT INTO esp.data (value, unit, sensor, time, `raw`, verify) VALUES ($value, '$unit','$sensor', DEFAULT, '$raw', '$verify')";
//        echo $sql;
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
        $sql = "DELETE FROM learn.page WHERE `id`='$id'";
        $result = mysqli_query($_db,$sql);
        if ($result){
            $res["message"] = "delete successfully";
        }else{
            $res["error"]=true;
            $res["message"]="delete failed";
        }
    }
    // 更新数据
    elseif ($action=='update'){
//        $id = $_POST['id'];
//        $data = $_POST['data'];
        $res["error"]=true;
        $res["message"]="Not allow modify data";
//        $sql = "UPDATE `learn`.page SET `id`='$id',`data`='$data' WHERE `id`='$id'";
//        $result = mysqli_query($_db,$sql);
//        if ($result){
//            $res["message"] = "update successfully";
//        }else{
//            $res["error"]=true;
//            $res["message"]="update failed";
//        }
    }

}


mysqli_close($_db);

echo json_encode($res);
//echo "hah";
die();


