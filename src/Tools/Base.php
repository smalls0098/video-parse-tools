<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Traits\HttpRequest;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 23:08
 **/
class Base
{

    use HttpRequest;

    //三个b不同客户端的User-Agent ：windows、android、ios （其他可以自己添加）
    const WIN_USER_AGENT = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36";
    const IOS_USER_AGENT = "Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1";
    const ANDROID_USER_AGENT = "Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.25 Mobile Safari/537.36";


    /**
     * 返回数据结果
     * return data results
     * @param string $url
     * @param string $userName
     * @param string $userHeadPic
     * @param string $desc
     * @param string $videoImage
     * @param string $videoUrl
     * @param string $type
     * @return array
     */
    protected function returnData(string $url, string $userName, string $userHeadPic, string $desc, string $videoImage, string $videoUrl, string $type): array
    {
        return [
            'md5' => md5($url),
            'message' => $url,
            'user_name' => $userName,
            'user_head_img' => $userHeadPic,
            'desc' => $desc,
            'img_url' => $videoImage,
            'video_url' => $videoUrl,
            'type' => $type
        ];
    }

    /**
     * 检查正则配到到的内容是否正确
     * check if the content assigned to the regular is correct
     * @param array $match 正则匹配参数
     * @return bool
     */
    protected function checkEmptyMatch($match)
    {
        return $match == null || empty($match[1]);
    }

}