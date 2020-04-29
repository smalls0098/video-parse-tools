<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 14:32
 **/
class XiaoKaXiu extends Base implements IVideo
{

    /**
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{XiaoKaXiu} url cannot be empty");
        }
        if (strpos($url, "mobile.xiaokaxiu.com") == false) {
            throw new ErrorVideoException("{XiaoKaXiu} the URL must contain one of the domain names izuiyou.com to continue execution");
        }
        preg_match('/video\?id=([0-9]+)/i', $url, $itemMatches);

        if ($this->checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("{XiaoKaXiu} url parsing failed");
        }

        $time = time();
        $sign = md5("S14OnTD#Qvdv3L=3vm&time=" . $time);

        $newGetContentUrl = 'https://appapi.xiaokaxiu.com/api/v1/web/share/video/' . $itemMatches[1];

        $contents = $this->get($newGetContentUrl, [
            'time' => $time,
        ], [
            'Referer' => $newGetContentUrl,
            'x-sign' => $sign,
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        if (isset($contents['code']) && $contents['code'] != 0) {
            throw new ErrorVideoException("{XiaoKaXiu} contents parsing failed");
        }



        return $this->returnData(
            $url,
            isset($contents['data']['video']['user']['nickname']) ? $contents['data']['video']['user']['nickname'] : '',
            '',
            isset($contents['data']['video']['title']) ? $contents['data']['video']['title'] : '',
            isset($contents['data']['video']['cover']) ? $contents['data']['video']['cover'] : '',
            isset($contents['data']['video']['url'][0]) ? $contents['data']['video']['url'][0] : '',
            'video'
        );
    }
}