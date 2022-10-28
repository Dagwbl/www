<?php
/** 样表
| id   | value | unit | sensor    | time                  | raw                                              | verify     |
| ---- | ----- | ---- | --------- | --------------------- | ------------------------------------------------ | ---------- |
| 737  | 17    |      | PMS7003-1 | 2022-09-01 11:38:34.0 | 424d01c0110180200110180209752ac08e01706009703ab  | L435T72191 |
| 738  | 57    |      | PMS7003-1 | 2022-09-01 11:38:37.0 | 424d01c05605e06303904004f31e9fc009301204009705b3 | L435T74706 |
| 739  | 78    |      | PMS7003-1 | 2022-09-01 11:38:39.0 | 424d01c07707e08104e05305c4665164c08b0b020097055a | L435T77447 |
| 740  | 111   |      | PMS7003-1 | 2022-09-01 11:38:42.0 | 424d01c0a90b10b406f07507662791f470980c0202970693 | L435T80081 |

esp.data 数据表操作，为了数据安全和确保数据的真实性起见，不允许进行数据修改和删除，也没有实现相应的功能
header("Content-type:application/x-www-form-urlencoded");
设置为application/json的头文件非常容易出现跨域问题，需要以下头文件
*/

header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:x-requested-with, Referer,content-type,token,DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

// 导入模块
require_once '../config/profile.php';
require_once '../config/db.php';
require_once '../utils/tools.php';
require_once '../utils/log.php';
require_once '../utils/control.php';

$logger = new log();

// 链接数据库
$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);

// 构建接口
// 返回的数据对象
//$opj_table =  "data";  //本文件主要操作esp.data表
$res = array();
if (isset($_GET['action'])){
    $action=$_GET['action'];
    //查询数据
    if ($action=='query'){
        if (isset($_GET['p'])){
            $page = $_GET['p'];
            $page_size = 20;
            $sql = "SELECT * FROM `esp`.data LIMIT " . ($page-1) * $page_size ." ,$page_size";
        }else{
            $sql = "SELECT * FROM `esp`.data";

        }
        $result = mysqli_query($_db,$sql);
        while ($row = mysqli_fetch_assoc($result)){
            $res[] = $row;
        }
    }
    // 插入数据
    elseif ($action=='insert') {
        $data = json_decode(file_get_contents("php://input"), true);
        var_dump($data);
//------------------直接最外层的数据用列表来进行解析----------------------
        foreach ($data as $item) {
            $value = $item['value'];
            $unit = $item['unit'];
            $sensor = $item['sensor'];
            $raw = $item['raw'];
            $verify = $item['verify'];
            $sql = "INSERT INTO esp.data (value, unit, sensor, time, `raw`, verify) VALUES ($value, '$unit','$sensor', DEFAULT, '$raw', '$verify')";
            echo $sql;
            $result = mysqli_query($_db, $sql);
            if ($unit=='℃'){
                $res['control']=control($value,$sensor);
            }
            if ($result) {
                $res["message"] = "Insert successfully";
            } else {
                $res["error"] = true;
                $res["message"] = "Insert failed";
            }
        }
    }
    // 删除数据，为安全起见不允许从客户端删除数据
    elseif ($action=='delete'){
        die("Not allow delete data");
    }
    // 更新数据功能，为确保数据真实性，不允许修改数据
    elseif ($action=='update'){
        die("Not allow modify data");
    }

}

echo json_encode($res);
// 关闭数据库链接,反复关闭可能会对性能有影响
//mysqli_close($_db);
//die();




