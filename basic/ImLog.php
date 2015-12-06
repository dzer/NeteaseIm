<?php
/**
 * 日志类.
 *
 * @author dx <358654744@qq.com>
 * @date 2015-11-05
 *
 * @version 1.0
 */
class ImLog
{
    const LOGFILE = 'im.log';

    public static function write($str)
    {
        $log = self::isbak();
        if ($fp = fopen($log, 'a')) {
            fwrite($fp, '['.date('Y-m-d H:i:s').'] '.$str."\r\n");
            fclose($fp);
        }
    }

    public static function isbak()
    {
        $log = IM_LOG_DIR.self::LOGFILE;
        if (!file_exists(IM_LOG_DIR)) {
            mkdir(IM_LOG_DIR, '0777');
        }
        //判断日志文件是否存在，不存在就创建
        if (!file_exists($log)) {
            touch($log);

            return $log;
        }
        //存在就判断大小，当小于1M时就直接返回
        $size = filesize($log);
        clearstatcache(); //清除文件状态缓存
        if ($size <= 1024 * 1024) {
            return $log;
        }
        //当大于1M时就另存一份
        if (self::bak()) {
            touch($log);

            return $log;
        } else {
            return $log;
        }
    }

    public static function bak()
    {
        $log = IM_LOG_DIR.self::LOGFILE;
        $bak = IM_LOG_DIR.'im.bak';

        return rename($log, $bak);
    }
}
