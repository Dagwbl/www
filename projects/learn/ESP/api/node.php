<?php
// 目前只适配了查询功能，其他功能勿用，更新光耦状态功能
/*
| id   | coords   | optocouple | response_level |
| ---- | -------- | ---------- | -------------- |
| 1    | f1r1     | 0          | 0              |
| 2    | f1r2t    | 0          | 0              |
| 5    | f1r3t    | 0          | 0              |
| 6    | f1r4t    | 0          | 0              |
| 7    | testnode | 0          | 0              |
| 8    | 435      | 0          | 0              |
 */
// 设置头响应头
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
    //查询数据
    if ($action=='query'){
        // 支持两种查询方式，一种是按页查询，另一种是具体的查询参数分别为p和coords
        if (isset($_GET['p'])){
            $page = $_GET['p'];
            $page_size = 20;
            $sql = "SELECT * FROM `esp`.node LIMIT " . ($page-1) * $page_size ." ,$page_size";
        }elseif (isset($_POST['coords'])){
            $coords=$_POST['coords'];
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
        $coords =$_POST['coords'];
        if (isset($_POST['optocouple'])){
            $optocouple = $_POST['optocouple'];
        }else{
            $optocouple = 0;
        }

        if (isset($_POST['response_level'])){
            $response_level =$_POST['response_level'];
        }else{
            $response_level = 0;
        }
        $sql = "INSERT INTO esp.node (coords, optocouple, response_level) VALUES ('$coords', '$optocouple','$response_level')";
        echo $sql;
        $result = mysqli_query($_db,$sql);
        if ($result){
            $res["message"] = "insert successfully";
        }else{
            $res["error"]=true;
            $res["message"]="insert failed";
        }
    }
    // 删除数据,由于未做处理，此处即使删除不存在的值也不会进行报错
    elseif ($action=='delete'){
//        $id = $_POST['id'];
        $coords = $_POST['coords'];
        $sql = "DELETE FROM esp.node WHERE `coords`='$coords'";
        $result = mysqli_query($_db,$sql);
        echo json_encode($result);
        if ($result==1){
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
        // 先把当前的记录查询出来
        $sql = "select * from esp.node where coords='$coords'";
        $result = mysqli_query($_db,$sql);
        $oldParams = mysqli_fetch_assoc($result);
        // 首先判断坐标是否存在，如果不存在则直接退出。
        if (empty($oldParams)){
            die("The coords($coords) doesn't exist.");
        }
        var_dump($oldParams);
        $optocouple = $oldParams['optocouple'];
        $response_level = $oldParams['response_level'];

        // 再从请求信息中覆盖一遍就可以得到新的值了。
        if (isset($_POST['optocouple'])){
            $optocouple = $_POST['optocouple'];
        }
        if (isset($_POST['response_level'])){
            $response_level = $_POST['response_level'];
        }
        $sql = "UPDATE `esp`.node SET optocouple='$optocouple',response_level='$response_level' WHERE `coords`='$coords'";
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


