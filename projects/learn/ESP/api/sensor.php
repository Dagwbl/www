<?php
// parameter表样式
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
require_once '../utils/log.php';
$logger = new log();

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
    $model=$_POST['model'];
    if (isset($_POST['node'])){
        $node=$_POST['node'];
    }
    //查询数据
    if ($action=='query'){
        if (isset($_GET['p'])){
            $page = $_GET['p'];
            $page_size = 20;
            $sql = "SELECT * FROM `$opj_db`.$opj_table LIMIT " . ($page-1) * $page_size ." ,$page_size";
        }elseif($model=='all'){
            $sql =             $sql = "SELECT * FROM `$opj_db`.$opj_table";
        }else{
            $sql = "SELECT * FROM `$opj_db`.$opj_table WHERE model='$model'";
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
        $node =$_POST['node'];
//        $model = $_POST['model'];
        $parameter =$_POST['parameter'];
        $upload =$_POST['upload'];
        $sql = "INSERT INTO $opj_db.$opj_table (node, model, parameter, upload) VALUES ('$node', '$model','$parameter','$upload')";
        echo $sql;
        $result = mysqli_query($_db,$sql);
        $logger::info("新增传感器",$model);
        if ($result){
            $res["message"] = "insert successfully";
        }else{
            $res["error"]=true;
            $res["message"]="insert failed";
        }
    }
    // 删除数据
    elseif ($action=='delete'){
//        $model = $_POST['model'];
        // 先把之前的记录查询出来
        $sql = "select * from esp.sensor where model='$model'";
        $result = mysqli_query($_db,$sql);
        if (empty(mysqli_fetch_assoc($result))){
            die("The model($model) doesn't exist");
        };
//        $data = $_POST['data'];
        $sql = "DELETE FROM $opj_db.$opj_table WHERE `model`='$model'";
        $result = mysqli_query($_db,$sql);
        $logger::info("删除传感器",$model);
        if ($result==1){
            echo $result;
            $res["message"] = "execute successfully";
        }else{
            $res["error"]=true;
            $res["message"]="delete failed";
        }
    }
    // 更新数据
    elseif ($action=='update'){
//        $model = $_POST['model'];
        // 先把之前的记录查询出来
        $sql = "select * from esp.sensor where model='$model'";
        $result = mysqli_query($_db,$sql);
        $oldParams = mysqli_fetch_assoc($result);
        $node = $oldParams['node'];
        $model=$oldParams['model'];
        $parameter=$oldParams['parameter'];
        $upload=$oldParams['upload'];
        // 首先判断坐标是否存在，如果不存在则直接退出。
        if (empty($oldParams)){
            die("The model($model) doesn't exist.");
        }
        //再从上传上来的参数中读取数据并覆盖
        if (isset($_POST['model'])){
            $model = $_POST['model'];
        }
        if (isset($_POST['parameter'])){
            $parameter =$_POST['parameter'];
        }
        if (isset($_POST['upload'])){
            $upload =$_POST['upload'];
        }
        $sql = "UPDATE $opj_db.$opj_table SET node='$node',parameter='$parameter',upload='$upload' WHERE `model`='$model'";
        echo $sql;
        $result = mysqli_query($_db,$sql);
        $logger::info("更新传感器",$model);
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
die();


