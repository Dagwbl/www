<?php
require_once __DIR__.'/conf.php';
return new PDO('mysql:host='.HOST.';dbname='.DBNAME,DBUSER,DBPASS);
