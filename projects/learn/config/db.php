<?php

//require_once './config/profile.php';

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

//connectDatabase(HOST, USERNAME, PASSWORD, DBNAME);