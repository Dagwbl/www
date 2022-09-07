<?php


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

    private static $log = '';

    public static function info($data, $immediate = false)
    {
        self::record($data, self::LEVEL_INFO, $immediate);
    }

    public static function debug($data, $immediate = false)
    {
        self::record($data, self::LEVEL_DEBUG, $immediate);
    }

    public static function error($data, $immediate = false)
    {
        self::record($data, self::LEVEL_ERROR, $immediate);
    }

    public static function warn($data, $immediate = false)
    {
        self::record($data, self::LEVEL_WARN, $immediate);
    }

    public static function write()
    {
        if (self::$log != '') {
            $file_name = self::DIR . date("Y-m-d") . ".log";
            file_put_contents($file_name, self::$log, FILE_APPEND);
            self::$log = '';
        }

    }

    private static function record($data, $level, $immediate = false)
    {
        if (self::isRecord($level)) {
            $prefix = date("Y-m-d H:i:s") . " [$level] ";
            self::$log .= $prefix . var_export($data, true) . PHP_EOL;

            if (self::isWrite($immediate)) self::write();
        }
    }

    private static function isRecord($level)
    {
        return self::compareLevel($level) >= 0;
    }


    private static function isWrite($immediate)
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

register_shutdown_function(function (){
    log::write();
});