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
header("Content-type:application/json");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:x-requested-with, Referer,content-type,token,DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

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

// 获取参数
$action = $_GET['action'] ?? 'query';
$page = $_GET['p'] ?? -1;
$pageSize = $_GET['pageSize'] ?? -1;
$coords = $_GET['coords'] ?? 0;
//查询数据
if ($action=='query'){
    // 支持两种查询方式，一种是按页查询，另一种是具体的查询参数分别为p和coords
    if ($page<>-1 && $pageSize <> -1){
        // 查询分页
        $sql = "SELECT * FROM `esp`.node LIMIT " . ($page-1) * $pageSize ." ,$pageSize";
        $total = mysqli_fetch_assoc(mysqli_query($_db,"SELECT count(1) total FROM `esp`.node"));
        $res['total'] = $total['total'];
        $res['pageNum'] = $page;
        $res['pageSize'] = $pageSize;
    }elseif ($coords){
        // 坐标查询
        $sql = "SELECT * FROM `esp`.node WHERE coords='$coords'";
    }else{
        //查询全部
        $sql = "SELECT * FROM `esp`.node";
    }
    $result = mysqli_query($_db,$sql);
    $row = mysqli_fetch_all($result,mode: MYSQLI_ASSOC);
    $res['data'] = $row;


}
// 插入数据
elseif ($action=='insert'){
    $data = json_decode(file_get_contents("php://input"), true);
//    var_dump($data);
    $coords =$data['coords'] ?? null;
    $optocouple =$data['optocouple'] ?? 0;
    $response_level =$data['response_level'] ?? 0;

    $sql = "INSERT INTO esp.node (coords, optocouple, response_level) VALUES ('$coords', '$optocouple','$response_level')";
//    echo $sql;
    $res['sql'] = $sql;
    try {
        $result = mysqli_query($_db,$sql);
        $res["message"] = "insert successfully";
    }catch (Exception $e){
        $res['error'] = $e->getMessage();
//        $res["error"]=true;
        $res["message"]="insert failed";
    }

}
// 删除数据,由于未做处理，此处即使删除不存在的值也不会进行报错
elseif ($action=='delete'){
    $data = json_decode(file_get_contents("php://input"), true);
//    var_dump($data);
    $coords =$data['coords'] ?? null;
    $optocouple =$data['optocouple'] ?? 0;
    $response_level =$data['response_level'] ?? 0;

    $sql = "DELETE FROM esp.node WHERE `coords`='$coords'";
    $result = mysqli_query($_db,$sql);
    if ($result==1){
//        echo $result;
        $res["message"] = "delete successfully";
    }else{
        $res["error"]=true;
        $res["message"]="delete failed";
    }
}
// 更新数据
elseif ($action=='update'){
    $data = json_decode(file_get_contents("php://input"), true);
//    var_dump($data);
    $coords =$data['coords'];
    $optocouple =$data['optocouple'] ?? 0;
    $response_level =$data['response_level'] ?? 0;

    // 先把当前的记录查询出来
    $sql = "select * from esp.node where coords='$coords'";
    $result = mysqli_query($_db,$sql);
    $oldParams = mysqli_fetch_assoc($result);
    // 首先判断坐标是否存在，如果不存在则直接退出。
    if (empty($oldParams)){
        die("The coords($coords) doesn't exist.");
    }

    $sql = "UPDATE `esp`.node SET optocouple='$optocouple',response_level='$response_level' WHERE `coords`='$coords'";
//    echo $sql;
    $result = mysqli_query($_db,$sql);
    if ($result){
        $res['sql']=$sql;
        $res['updated'] = $data;
        $res["message"] = "update successfully";
    }else{
        $res["error"]=true;
        $res["message"]="update failed";
    }
}


mysqli_close($_db);

echo json_encode($res);
die();


