<?php
// 此文件提供了客户端自由编辑SQL并运行的能力，为了保护数据安全的考虑，禁止了一些操作的执行。
// 更改为数据导出功能

// 设置响应头,解决跨域问题必须要设置的请求头
header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:x-requested-with, Referer,content-type,token,DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

// 连接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
$_db = connectDatabase(HOST, USERNAME, PASSWORD, DBNAME);

$action = $_GET['action'] ?? 'preview';
$table = $_GET['table'] ?? null;
$page = $_GET['p'] ?? 1;
$pageSize = $_GET['pageSize'] ?? 15;
$filter = $_GET['filter'] ?? null;
$time = $_GET['date'] ?? null;

//var_dump($_GET);

//$allData = json_decode(file_get_contents("php://input"), true);
//var_dump($allData);

$res = [];
$banKeywords = ['delete', 'drop'];

//$sql = $_POST['sql'];
$isAllow = true;
foreach ($banKeywords as $keyword) {
    if (str_contains($action, $keyword)) {
        $isAllow = false;
    }
}
if ($isAllow) {
    if ($table) {
        if ($filter && $time) {
            $filter = 'where ' . $filter . ",time like '$time%";
        } elseif ($filter && !$time) {
            $filter = 'where ' . $filter;
        } elseif (!$filter && $time) {
            $filter = 'where ' . "time like '$time%";
        } else {
            $filter = '';
        }

        if ($action == 'preview') {
            $sql = "select * from $table $filter limit " . ($page - 1) * $pageSize . ",$pageSize";
        } elseif ($action == 'export') {
            $sql = "select * from $table $filter";
        } else {
            die("action not valid");
        }
        $total_sql = "select count(*) total from $table $filter";
        $result = mysqli_query($_db, $sql);
        $res['sql'] = $sql;
        $res['pageNum'] = $page;
        $res['pageSize'] = $pageSize;
        $res['data'] = mysqli_fetch_all($result, mode: MYSQLI_ASSOC);
        $res['total'] = mysqli_fetch_assoc(mysqli_query($_db, $total_sql))['total'];

        $res['message'] = 'Execute successfully';
        $res['error'] = false;


    } else {
        $res['error'] = true;
        $res['message'] = 'The SQL contains forbid keywords';

    }

} else {
    $res['error'] = '参数不完整';
}

echo json_encode($res);

