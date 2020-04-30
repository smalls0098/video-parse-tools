<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 13:51
 **/
class HuoShan extends Base implements IVideo
{


    /**
     * 更新时间：2020/4/30
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {

        if (empty($url)) {
            throw new ErrorVideoException("{HuoShan} url cannot be empty");
        }

        if (strpos($url, "huoshan.com") == false) {
            throw new ErrorVideoException("{HuoShan} the URL must contain one of the domain names huoshan.com to continue execution");
        }

        $originalUrl = $this->redirects($url, [], [
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        preg_match('/item_id=([0-9]+)&tag/i', $originalUrl, $match);
        if ($this->checkEmptyMatch($match)) {
            throw new ErrorVideoException("{HuoShan} originalUrl parsing failed");
        }

        $contents = $this->get('https://share.huoshan.com/api/item/info', [
            'item_id' => $match[1]
        ], [
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        if ((isset($contents['status_code']) && $contents['status_code'] != 0) || (isset($contents['data']) && $contents['data'] == null)) {
            throw new ErrorVideoException("{HuoShan} contents parsing failed");
        }

        $videoUrl = isset($contents['data']['item_info']['url']) ? $contents['data']['item_info']['url'] : '';

        $parseUrl = parse_url($videoUrl);
        if(empty($parseUrl['query'])) {
            throw new ErrorVideoException("{HuoShan} parseUrl parsing failed");
        }
        parse_str($parseUrl['query'], $parseArr);
        $parseArr['watermark'] = 0;

        $videoUrl = $this->redirects('https://api.huoshan.com/hotsoon/item/video/_source/', $parseArr, [
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        return $this->returnData(
            $url,
            '',
            '',
            '',
            $contents['data']['item_info']['cover'],
            $videoUrl,
            'video'
        );
    }
}