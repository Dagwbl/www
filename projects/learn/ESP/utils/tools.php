<?php
/**
 * 提供一些项目常规函数工具
 */

require_once "../config/profile.php";

/**
 * node ID 转换函数，支持 string ID 和 int ID 互转
 * f2r4c2 通过正则表达式分解为如下数组
 * Array
 * (
 * [0] =>
 * [1] => 2
 * [2] => 4
 * [3] => 2
 * )
 *
 * @param string|int $ignite_location
 * @return int|string
 */
function nodeIdConvert(string|int $ignite_location ): int|string
{
    if (is_string($ignite_location)){
        $chars = preg_split('/[frct]/', $ignite_location);
//        print_r(($chars[1]-1)*NUM_OF_ROOMS+$chars[2]);
        return $chars[1]*NUM_OF_FLOORS+$chars[2];
    }else{
        $n =intval($ignite_location/NUM_OF_ROOMS);
        $m = $ignite_location%NUM_OF_ROOMS;
//        print_r("f".$n."r".$m);
        return "f".$n."r".$m;
    }
}

//nodeIdConvert('f2r3c2');
//nodeIdConvert(13);

/**
 * 生成房间数组
 *
 * @param int $idx_floor
 * @param int $idx_room
 * @return array
 * @deprecated 压根不用生成，直接从数据库读取就好
 */
function generateArray(int $idx_floor, int $idx_room): array
{
    $nodes = array();
    for ($f = 1; $f <= $idx_floor; $f++) {
        for ($r = 1; $r <= $idx_room; $r++) {
            if ($r % 2 == 1) {
                $nodes[$f][0][] = $r;
            } else {
                $nodes[$f][1][] = $r;
            }
        }
    }
    return $nodes;
};

