<?php

require "../ESP/utils/log.php";

$log3 = new log();

$log3::debug([1,3,4,65,5]);
$log3::info(3);
$log3::error("err");
$log3::warn("jhg");

echo 'test';