<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;
/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 21:57
 **/

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;

class PiPiXia extends Base implements IVideo
{


    public function __construct($params)
    {
    }

    /**
     * 更新时间：2020/4/30
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{PiPiXia} url cannot be empty");
        }

        if (strpos($url, "pipix.com") == false) {
            throw new ErrorVideoException("{PiPiXia} the URL must contain one of the domain names pipix.com to continue execution");
        }

        $originalUrl = $this->redirects($url, [], [
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        preg_match('/item\/([0-9]+)\?/i', $originalUrl, $match);
        if ($this->checkEmptyMatch($match)) {
            throw new ErrorVideoException("{PiPiXia} originalUrl parsing failed");
        }
        $newGetContentsUrl = 'https://h5.pipix.com/bds/webapi/item/detail/';

        $contents = $this->get($newGetContentsUrl, [
            'item_id' => $match[1],
        ], [
            'Referer' => $newGetContentsUrl,
            'User-Agent' => self::ANDROID_USER_AGENT
        ]);

        if (empty($contents['data']['item'])) {
            throw new ErrorVideoException("{TouTiao} contents parsing failed");
        }
        $videoArr = $contents['data']['item'];
        return $this->returnData(
            $url,
            isset($videoArr['author']['name']) ? $videoArr['author']['name'] : '',
            isset($videoArr['author']['avatar']['url_list'][0]['url']) ? $videoArr['author']['avatar']['url_list'][0]['url'] : '',
            isset($videoArr['share']['title']) ? $videoArr['share']['title'] : '',
            isset($videoArr['video']['cover_image']['url_list'][0]['url']) ? $videoArr['video']['cover_image']['url_list'][0]['url'] : '',
            isset($videoArr['video']['video_fallback']['url_list'][0]['url']) ? $videoArr['video']['video_fallback']['url_list'][0]['url'] : '',
            'video'
        );
    }
}