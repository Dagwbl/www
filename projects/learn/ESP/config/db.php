<?php

/**
 * 链接数据库
 * @param string $host
 * @param string $username
 * @param string $password
 * @param string $db
 * @return mysqli
 */
function connectDatabase(string $host, string $username, string $password, string $db, ): mysqli
{
    $conn = mysqli_connect($host, $username, $password, $db);
    if (!$conn) {
        echo "connect fail";
        exit;
    }

    mysqli_select_db($conn, $db);

    return $conn;
}

if (realpath(__FILE__)==realpath($_SERVER['SCRIPT_FILENAME'])){
    connectDatabase(HOST, USERNAME, PASSWORD, DBNAME);
}
