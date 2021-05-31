<?php


namespace smalls\videoParseTools\utils;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
class CommonUtil
{

    /**
     * 检查正则配到到的内容是否正确
     * check if the content assigned to the regular is correct
     * @param array $match 正则匹配参数
     * @return bool
     */
    public static function checkEmptyMatch(array $match): bool
    {
        return $match == null || empty($match[1]);
    }

    public static function getData($data)
    {
        if (empty($data)) {
            return '';
        }
        return $data;
    }

}