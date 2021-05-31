<?php


namespace smalls\videoParseTools\common;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
trait Log
{

    private $debug = false;

    protected $logDir = __DIR__ . "/../../log/";

    /**
     * 测试的时候写入日志使用
     * @param string $contents
     * @param string $suffix
     */
    public function WriterTestLog(string $contents = '', string $suffix = 'log')
    {
        if ($this->debug) {
            file_put_contents($this->logDir . (string)time() . "." . $suffix, $contents);
        }
    }

}