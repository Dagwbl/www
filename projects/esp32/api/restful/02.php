<?php
$path = $_SERVER['PATH_INFO'];
$arr = explode('/',$path);
print_r($arr);

if($arr[1] == 'user'){
    $model = new UserModel();
    $id = $arr[2];
    if($id){ //读取用户信息
        $user_info = $model->find($id);
        echo json_encode($user_info);
    }else{
        if(IS_POST){ //增加用户
            $res = $model->add($_POST);
            if($res){ echo 'success';
            }else{ echo 'fail'; }
        }else{ //读取用户列表
            $user_list = $model->select();
            echo json_encode($user_list); } } }