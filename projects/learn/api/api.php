<?php
header("Content-type:application/json");
header("Access-Control-Allow-Origin:*");
// 设计数据库

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);
//$_db->query("set data utf8");
// 构建接口
// 返回的数据对象
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
            $sql = "SELECT * FROM `learn`.page LIMIT " . ($page-1) * $page_size ." ,$page_size";
        }else{
        $sql = "SELECT * FROM `learn`.page";

        }
        $result = mysqli_query($_db,$sql);
        while ($row = mysqli_fetch_assoc($result)){
            $res[] = $row;
        }

    }
    // 插入数据
    elseif ($action=='insert'){
        $data = $_POST['data'];
        $sql = "INSERT INTO `learn`.page (`data`) value ('$data')";
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
        $id = $_POST['id'];
        $data = $_POST['data'];
        $sql = "UPDATE `learn`.page SET `id`='$id',`data`='$data' WHERE `id`='$id'";
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


