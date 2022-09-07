<?php
// 目前只适配了查询功能，其他功能勿用，更新光耦状态功能

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
$opj_table =  "node";  //本文件主要操作esp.node表
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
            $sql = "SELECT * FROM `esp`.node LIMIT " . ($page-1) * $page_size ." ,$page_size";
        }else{
            $sql = "SELECT * FROM `esp`.node WHERE coords='$coords'";
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

        $sql = "INSERT INTO esp.data (value, unit, sensor, time, `raw`, verify) VALUES ($value, '$unit','$sensor', DEFAULT, '$raw', '$verify')";
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
        #$id = $_POST['id'];
        $coords = $_POST['coords'];
        $opt_status = $_POST['optocouple'];
        $sql = "UPDATE `esp`.node SET optocouple=$opt_status WHERE `coords`='$coords'";
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


