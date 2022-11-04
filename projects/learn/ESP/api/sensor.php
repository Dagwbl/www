<?php
// parameter表样式
/*
      "id": "137",
      "node": "f1r1",
      "model": "testsensor-1",
      "parameter": "temperature",
      "unit": "℃",
      "range": "0-1000",
      "upload": "1",
      "optocouple": "0"
*/
//header("Content-type:application/x-www-form-urlencoded");
header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:x-requested-with, Referer,content-type,token,DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

// 设计数据库

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
require_once '../utils/log.php';
$logger = new log();

$_db = connectDatabase(HOST, USERNAME, PASSWORD, DBNAME);
//$_db->query("set data utf8");
// 构建接口
// 返回的数据对象
$opj_db = 'esp';
$opj_table = "sensor";  //本文件主要操作esp.sensor表

$res = array();

$action = $_GET['action'] ?? 'query';


//查询数据
if ($action == 'query') {
    $model = $_GET['model'] ?? null;
    $node = $_GET['node'] ?? null;
    $page = $_GET['p'] ?? -1;
    $pageSize = $_GET['pageSize'] ?? -1;
    if ($page > 0) {
        $sql = "SELECT * FROM `$opj_db`.$opj_table LIMIT " . ($page - 1) * $pageSize . " ,$pageSize";
        $total = mysqli_fetch_assoc(mysqli_query($_db, "SELECT count(1) total FROM `esp`.sensor"));
        $res['total'] = $total['total'];
        $res['pageNum'] = $page;
        $res['pageSize'] = $pageSize;
    } elseif ($model == 'all') {
        $sql = $sql = "SELECT * FROM `$opj_db`.$opj_table";
    } else {
        $sql = "SELECT * FROM `$opj_db`.$opj_table WHERE model='$model'";
    }
    $result = mysqli_query($_db, $sql);

    $res['status'] = true;
    $res['data'] = mysqli_fetch_all($result, mode: MYSQLI_ASSOC);


} // 插入数据
elseif ($action == 'insert') {
    // json 数据，多个对象，用列表封装[{},{}]
    $allData = json_decode(file_get_contents("php://input"), true);
    var_dump($allData);
    foreach ($allData as $data) {
        $node = $data['node'];
        $model = $data['model'];
        $parameter = $data['parameter'] ?? null;
        $upload = $data['upload'] ?? 1;
        $sql = "INSERT INTO $opj_db.$opj_table (node, model, parameter, upload) VALUES ('$node', '$model','$parameter','$upload')";
//        echo $sql;
        try {
            mysqli_query($_db, $sql);
            $logger::info("新增传感器", $model);
            $res["status"] = true;
        } catch (Exception $e) {
            $res["error"] = false;
            $res["message"] = $e->getMessage();
        }

    }
} // 删除数据
elseif ($action == 'delete') {
    // json 数据，单个对象[]
    $data = json_decode(file_get_contents("php://input"), true);
    $model = $data['model'];
    // 先把之前的记录查询出来
    $sql = "select * from esp.sensor where model='$model'";
    $result = mysqli_query($_db, $sql);
    if (empty(mysqli_fetch_assoc($result))) {
        die("The model($model) doesn't exist");
    }
    $sql = "DELETE FROM $opj_db.$opj_table WHERE `model`='$model'";
    $result = mysqli_query($_db, $sql);
    $logger::info("删除传感器", $model);
    if ($result == 1) {
        $res["message"] = "execute successfully";
    } else {
        $res["error"] = true;
        $res["message"] = "delete failed";
    }


} // 更新数据
elseif ($action == 'update') {
    // json 数据，单个对象[]
    $data = json_decode(file_get_contents("php://input"), true);
    $model = $data['model'];

    // 先把之前的记录查询出来
    $sql = "select * from esp.sensor where model='$model'";
    $result = mysqli_query($_db, $sql);
    $oldParams = mysqli_fetch_assoc($result);
    // 首先判断坐标是否存在，如果不存在则直接退出。
    if (empty($oldParams)) {
        die("The model($model) doesn't exist.");
    }
    $node = $oldParams['node'];
    $model = $oldParams['model'];
    $parameter = $oldParams['parameter'];
    $upload = $oldParams['upload'];

    //再从上传上来的参数中读取数据并覆盖
    $node = $data['node'] ?? $oldParams['node'];
    $parameter = $data['parameter'] ?? $oldParams['parameter'];
    $unit = $data['unit'] ?? $oldParams['unit'];
    $range = $data['range'] ?? $oldParams['range'];
    $upload = $data['upload'] ?? $oldParams['upload'];
    $optocouple = $data['optocouple'] ?? $oldParams['optocouple'];

    $sql = "UPDATE $opj_db.$opj_table SET node='$node',parameter='$parameter',upload='$upload' WHERE `model`='$model'";
    $result = mysqli_query($_db, $sql);
    $logger::info("更新传感器", $model);
    if ($result) {
        $res["message"] = "update successfully";
    } else {
        $res["error"] = true;
        $res["message"] = "update failed";
    }
}


mysqli_close($_db);

echo json_encode($res);
die();


