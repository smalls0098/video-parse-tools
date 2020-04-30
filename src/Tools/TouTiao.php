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
class TouTiao extends Base implements IVideo
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
            throw new ErrorVideoException("{TouTiao} url cannot be empty");
        }
        if (strpos($url, "toutiaoimg.com") == false && strpos($url, "toutiaoimg.cn") == false) {
            throw new ErrorVideoException("{TouTiao} the URL must contain one of the domain names toutiaoimg.com or toutiaoimg.cn to continue execution");
        }
        preg_match('/a([0-9]+)\/?/i', $url, $match);
        if ($this->checkEmptyMatch($match)) {
            throw new ErrorVideoException("{TouTiao} url parsing failed");
        }

        return $this->getContents($url, $match[1]);
    }


    protected function getContents(string $url, $videoId)
    {
        $getContentUrl = 'https://m.365yg.com/i' . $videoId . '/info/';

        $contents = $this->get($getContentUrl, ['i' => $videoId], [
            'Referer' => $getContentUrl,
            'User-Agent' => self::ANDROID_USER_AGENT
        ]);

        if (empty($contents['data']['video_id'])) {
            throw new ErrorVideoException("contents parsing failed");
        }

        $videoUrl = $this->redirects('http://hotsoon.snssdk.com/hotsoon/item/video/_playback/', [
            'video_id' => $contents['data']['video_id'],
        ], [
            'User-Agent' => self::ANDROID_USER_AGENT
        ]);

        return $this->returnData(
            $url,
            isset($contents['data']['media_user']['screen_name']) ? $contents['data']['media_user']['screen_name'] : '',
            isset($contents['data']['media_user']['avatar_url']) ? $contents['data']['media_user']['avatar_url'] : '',
            isset($contents['data']['title']) ? $contents['data']['title'] : '',
            isset($contents['data']['poster_url']) ? $contents['data']['poster_url'] : '',
            $videoUrl,
            'video'
        );

    }

}