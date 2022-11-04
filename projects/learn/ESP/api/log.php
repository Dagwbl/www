<?php
// 此文件提供了客户端自由编辑SQL并运行的能力，为了保护数据安全的考虑，禁止了一些操作的执行。

// 设置响应头
header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:x-requested-with, Referer,content-type,token,DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

// 连接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
require_once '../utils/log.php';

$logger = new log();

$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);

$res = [];
//var_dump($_GET);
$action = $_GET['action'] ?? 'query';
$event = $_GET['event'] ?? null;
$page = $_GET['p'] ?? 1;
$pageSize = $_GET['pageSize'] ?? 20;

if ($action=='query'){
    if ($event==''){
        $sql = "select * from esp.log order by id desc limit ".($page-1)*$pageSize.", $pageSize";
        $total = mysqli_fetch_assoc(mysqli_query($_db, 'select count(1) total from esp.log'));
    }
    else{
        $sql = "select * from esp.log where event='$event' order by id desc limit ".($page-1)*$pageSize.", $pageSize";
        $total = mysqli_fetch_assoc(mysqli_query($_db, "select count(1) total from esp.log where event='$event'"));
    }
//echo $sql;
    $res['total'] = $total['total'];
    $res['pageNum'] = $page;
    $res['pageSize'] = $pageSize;
    $result = mysqli_query($_db,$sql);
    $res['data']=mysqli_fetch_all($result,mode: MYSQLI_ASSOC);
}
elseif ($action='insert'){
    // 接受数据为单个对象{}
    $data = json_decode(file_get_contents("php://input"), true);
    var_dump($data);
//    $event = $data['event'];
    $details = $data['details'];
    $raw = $data['raw'];
    $logger::debug($details,$raw,true);
    $res['status'] = 'Done';

}



// 下面语句只在模块直接启动时生效
if (realpath(__FILE__)==realpath($_SERVER['SCRIPT_FILENAME'])){
    echo json_encode($res);
}



