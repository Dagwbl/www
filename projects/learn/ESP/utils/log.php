<?php

require_once '../config/db.php';
require_once '../config/profile.php';
$_db = connectDatabase(HOST,USERNAME,PASSWORD,DBNAME);

class log
{

    const LEVEL_INFO = 'info';
    const LEVEL_DEBUG = 'debug';
    const LEVEL_ERROR = 'error';
    const LEVEL_WARN = 'warn';

    //全局配置
    //最多多少字节数写一次文件
    const MAX_LENGTH = '102400';
    //是否每次都写文件
    const WRITE_IMMEDIATE = false;
    //文件写日志级别
    const RECORD_LEVEL = 'info';
    //日志文件目录
    const DIR = __DIR__ . '/log/';

    private static string $log = '';

    public static function info($data, $raw, $immediate = false): void
    {
        self::record($data, self::LEVEL_INFO, $raw, $immediate);
    }

    public static function debug($data, $raw, $immediate = false): void
    {
        self::record($data, self::LEVEL_DEBUG, $raw, $immediate);
    }

    public static function error($data, $raw, $immediate = false): void
    {
        self::record($data, self::LEVEL_ERROR, $raw, $immediate);
    }

    public static function warn($data, $raw, $immediate = false): void
    {
        self::record($data, self::LEVEL_WARN, $raw, $immediate);
    }

    public static function write(): void
    {
        if (self::$log != '') {
            $file_name = self::DIR . date("Y-m-d") . ".log";
            file_put_contents($file_name, self::$log, FILE_APPEND);
            self::$log = '';
        }

    }
// event--level, details--data,
    private static function record($data, $level, $raw=null, $immediate = false): void
    {
        echo $raw;
//        $raw = var_export($raw,false);

        if (self::isRecord($level)) {
            $prefix = date("Y-m-d H:i:s ||") . " [$level] ||";
//            self::$log .= $prefix . var_export($data, true) ."||". $raw . PHP_EOL;
            self::$log .= $prefix . $data ."||". $raw . PHP_EOL;
            self::insertDB(date("Y-m-d H:i:s"),$data, $level, $raw);
            if (self::isWrite($immediate)) self::write();
        }
    }

    private static function isRecord($level): bool
    {
        return self::compareLevel($level) >= 0;
    }

    private static function insertDB($time,$data, $level, $raw=null): void
    {
        global $_db;
        $sql = "insert into esp.log (time, event, details,raw) VALUES ('$time','$level','$data','$raw')";
        mysqli_query($_db,$sql);

    }


    private static function isWrite($immediate): bool
    {
        return self::WRITE_IMMEDIATE || $immediate || strlen(self::$log) > self::MAX_LENGTH;
    }

    private static function compareLevel($level)
    {
        $debug = 1;
        $info = 2;
        $warn = 3;
        $error = 4;

        $writeLevel = self::RECORD_LEVEL;
        return $$level - $$writeLevel;
    }

}

register_shutdown_function(function () {
    log::write();
});

// 下面语句只在模块直接启动时生效
if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    log::error("测试","raw",true);

}