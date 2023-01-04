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
$coords = $_GET['coords'] ?? 0;
//查询数据
if ($action=='query'){
    // 支持两种查询方式，一种是按页查询，另一种是具体的查询参数分别为p和coords
    $sql = "select optocouple from node where coords=" . "'$coords'";
//    echo $sql;
    $result = mysqli_query($_db,$sql);
    $row = mysqli_fetch_all($result,mode: MYSQLI_ASSOC);
    $res['data'] = $row;


}

mysqli_close($_db);

echo json_encode($res);
die();


