<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Utils;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/10 - 14:50
 **/
class MeiPaiUtil
{
    public static function getHex($base64)
    {
        return [
            strrev(substr($base64, 0, 4)),
            substr($base64, 4)
        ];
    }

    public static function getDec($str)
    {
        $a_arr = [];
        $b_arr = [];
        foreach (str_split((string)hexdec($str)) as $id => $v) {
            if ($id >= 2) {
                $b_arr[] = $v;
            } else {
                $a_arr[] = $v;
            }
        }
        return array($a_arr, $b_arr);
    }

    public static function subStr($arr, $hex)
    {
        $k = $arr[0];
        $c = substr($hex, 0, (int)$k);
        $temp = str_replace(substr($hex, (int)$k, (int)$arr[1]), "", substr($hex, (int)$arr[0]));
        return $c . $temp;
    }

    public static function getPos($a, $b)
    {
        $b[0] = (string)(strlen($a) - $b[0] - $b[1]);
        return $b;
    }
}