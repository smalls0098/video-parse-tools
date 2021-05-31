<?php


namespace smalls\videoParseTools\interfaces;

use smalls\videoParseTools\parse\model\ParseResponse;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
interface IParse
{

    /**
     * @param string $url 需要解析的url
     * @return ParseResponse 解析响应类
     */
    public function start(string $url): ParseResponse;

}