<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Utils;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/10 - 12:56
 **/
class CommonUtil
{

    /**
     * 检查正则配到到的内容是否正确
     * check if the content assigned to the regular is correct
     * @param array $match 正则匹配参数
     * @return bool
     */
    public static function checkEmptyMatch($match)
    {
        return $match == null || empty($match[1]);
    }

    public static function getData($data)
    {
        if (empty($data)) {
            return '';
        }
        if ($data == null) {
            return '';
        }
        return $data;
    }

    public static function checkArrContainStr(array $arr, string $str)
    {
        $result = false;
        foreach ($arr as $v) {
            if (strpos($str, $v)) {
                $result = true;
                break;
            }
        }
        return $result;
    }

}