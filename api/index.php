<?php
require __DIR__.'/vendor/autoload.php';
$db = require_once __DIR__.'/lib/db.php';
require_once __DIR__.'/class/User.php';
require_once __DIR__.'/class/Article.php';
require_once __DIR__.'/class/Rest.php';

$user = new User($db);
$article = new Article($db);
$api = new Rest($user,$article);
$api->run();

dump($article->getList(10));



//dump($_SERVER);


////$re = $user->register('dagwbl24','1005');
//try {
//    $re = $user->login('dagwbl24', '1005');
//} catch (Exception $e) {
//}
////echo print_r($re);
////var_dump($re);
//

////try {
////    $re = $ar->create('title demo', 'content demo', '1');
////} catch (Exception $e) {
////}
////
//
//
//$ar = new Article($db);
//echo "<pre>";
////var_dump($re);
//try {
//    var_dump(value: $ar->delete(4, 1));
//} catch (Exception $e) {
//    var_dump($e);
//}
//echo "</pre>";
//
//
//
