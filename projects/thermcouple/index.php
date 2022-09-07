<?php
$read_post = '{"api_key":"tPmAT5Ab3j7F9","lm35dz":"123.1", "thermcouple":"21.43", "probetime":"23423", "seq":"1"}';

$data = json_decode($read_post,true);

echo $data;
