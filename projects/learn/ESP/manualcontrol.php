<?php
require_once './db.php';
require_once './profile.php';



// connect database
$_db = connectDatabase(HOST, USERNAME, PASSWORD, DBNAME);
// 显示数据和分页条
mysqli_select_db($_db,DBNAME);
$status = $_POST['status1']=='on'?1:0;
$coords = $_POST['coords'];
echo $status;
//$sql = "UPDATE TABLE esp.node optocouple=".$status." where coords='".$coords."'";
$sql = "UPDATE esp.node t SET t.optocouple = ".$status." WHERE t.coords = '".$coords."'";
echo $sql;
$result = mysqli_query($_db,$sql);
echo "<br>";
echo $result;
echo "数据更新成功";