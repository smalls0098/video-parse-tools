<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Enumerates;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/10 - 12:54
 **/
class UserGentType
{

    //三个不同客户端的User-Agent ：windows、android、ios （其他可以自己添加）

    /**
     * windows下面的浏览器
     */
    const WIN_USER_AGENT = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36";

    /**
     * IOS下面的浏览器
     */
    const IOS_USER_AGENT = "Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1";

    /**
     * android下面的浏览器
     */
    const ANDROID_USER_AGENT = "Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.25 Mobile Safari/537.36";

}