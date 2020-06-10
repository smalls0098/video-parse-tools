<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Enumerates;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/8 - 23:45
 **/
class BiliQualityType
{
    /**
     * 在80以上，例如2K、1080P60都需要登录或者会员才可以
     * 需要指定cookie信息
     */

    //流畅 360P
    const LEVEL_1 = 16;

    //清晰 480P
    const LEVEL_2 = 32;

    //高清 720P
    const LEVEL_3 = 64;

    //高清 720P60
    const LEVEL_4 = 74;

    //高清 1080P
    const LEVEL_5 = 80;

    //高清 1080P60
    const LEVEL_6 = 116;

}