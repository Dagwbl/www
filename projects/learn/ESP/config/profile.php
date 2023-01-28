<?php

/**
 * 系统参数配置
 *
 */

//数据库配置
const HOST = 'localhost';
const USERNAME = 'root';
const PASSWORD = '1005';
const DBNAME = 'esp';


// 基础控制参数配置
const THIRD_THRESHOLD = 95;
const SECOND_THRESHOLD = 85; // 150
const FIRST_THRESHOLD = 65; // 70
const RESTORE_THRESHOLD = 40;
const RESTORE_FLAG = true; // 是否自动恢复标记
const SPRAY_FLAG = false; // 是否喷雾标记
// 高层建筑基础参数
const NUM_OF_FLOORS = 12; // 楼层数
const NUM_OF_ROOMS = 10; // 每层房间数
const EXPERIMENT_SEQ = '准备';
//const EXPERIMENT_SEQ = '实验10-3';

$res = [];