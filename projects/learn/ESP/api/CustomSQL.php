<?php
// 此文件提供了客户端自由编辑SQL并运行的能力，为了保护数据安全的考虑，禁止了一些操作的执行。

// 设置响应头,解决跨域问题必须要设置的请求头
header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:x-requested-with, Referer,content-type,token,DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

// 连接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);

$res = [];
$allData = json_decode(file_get_contents("php://input"), true);
//var_dump($allData);
$sql = $allData['sql'] ?? null;
$banKeywords = ['delete','drop'];
if($sql){

    $isAllow = true;
    foreach ($banKeywords as $keyword){
        if(str_contains($sql, $keyword)){
            $isAllow = false;
        }
    }
    if($isAllow){
        $result = mysqli_query($_db,$sql);
        $res['result']=mysqli_fetch_all($result);
        $res['message']='Execute successfully';
        $res['error'] = false;
    }
    else{
        $res['error']=true;
        $res['message']='The SQL contains forbid keywords';

    }

}
else{
    $res['error']='A SQL command is expected';
}

echo json_encode($res);

