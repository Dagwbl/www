<?php

// 链接数据库
require_once '../config/profile.php';
require_once '../config/db.php';
$_db = connectDatabase(HOST, USERNAME, PASSWORD, DBNAME);


// 给node表批量添加房间
function addNode(): void
{
    global $_db;
    for ($f = 1; $f <= 12; $f++) {
        for ($r = 1; $r <= 10; $r++) {
            $coords = "f" . "$f" . "r" . "$r";
            $sql = "insert into esp.node (coords, optocouple) VALUES ('$coords',1)";
            try {
                $result = mysqli_query($_db, $sql);
            } catch (Exception $e) {
                echo $e;
                continue;
            }
        }

    }
}

/**
 * add sensor
 * @return void
 */
function addSensor(): void
{
    global $_db;
    $i = 1;
    for ($f = 1; $f <= 12; $f++) {
        for ($r = 1; $r <= 10; $r++) {
            $coords = "f" . "$f" . "r" . "$r";
            $model = 'testsensor-' . "$i";
            $old_model = 'testsensor' . "$i";
            $i++;
//            $sql = "insert into esp.sensor (node, model, parameter, unit, `range`) VALUES ('$coords','$model','temperature','℃','0-1000')";
            $sql = "update esp.sensor set model='$model' where model='$old_model'";
            try {
                $result = mysqli_query($_db, $sql);
            } catch (Exception $e) {
                echo $e;
                continue;
            }
        }

    }
}


/**
 * @throws Exception
 */
function addData(): void
{
    global $_db;
    for ($i = 0; $i < 5; $i++) {
        for ($r = 1; $r <= 120; $r++) {
            $model = "testsensor-" . "$r";
            $value = random_int(23, 70);
            $sql = "insert into esp.data (value, unit, sensor, time, raw, verify) VALUES ('$value','℃','$model',DEFAULT,DEFAULT,'randomData')";
            try {
                $result = mysqli_query($_db, $sql);
            } catch (Exception $e) {
                echo $e;
                continue;
            }
        }

    }


}

//addNode();
//addSensor();
try {
    addData();
} catch (Exception $e) {
    echo $e;
}