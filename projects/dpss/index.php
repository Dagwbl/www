<?php

require __DIR__.'/vendor/autoload.php'; //配置dump

require_once __DIR__ . '/class/PhysicalPole.php';
require_once __DIR__.'/class/SensorData.php';

$db = require_once __DIR__.'/lib/db.php';

$physicalPoles = new PhysicalPole($db);
$sensorData = new SensorData($db);

$test = $sensorData->byFilter("limit 10");
$test = $physicalPoles->getALL();

dump($test);
