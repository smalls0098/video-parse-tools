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

class DouYin extends Base implements IVideo
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
            throw new ErrorVideoException("{DouYin} url cannot be empty");
        }

        if (strpos($url, "douyin.com") == false && strpos($url, "iesdouyin.com") == false) {
            throw new ErrorVideoException("{DouYin} the URL must contain one of the domain names douyin.com or iesdouyin.com to continue execution");
        }

        $contents = $this->get($url, [], [
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        preg_match('/dytk:[^+]"(.*?)"[^+]}\);/i', $contents, $dyTks);
        preg_match('/itemId:[^+]"(.*?)",/i', $contents, $itemIds);

        if ($dyTks == null || $itemIds == null) {
            throw new ErrorVideoException("{DouYin} dyTk or itemId is empty, there may be a problem with the website");
        }

        $contents = $this->get('https://www.iesdouyin.com/web/api/v2/aweme/iteminfo', [
            'item_ids' => $itemIds[1],
            'dytk' => $dyTks[1],
        ], [
            'User-Agent' => self::ANDROID_USER_AGENT,
            'Referer' => "https://www.iesdouyin.com",
            'Host' => "www.iesdouyin.com",
        ]);

        if ((isset($contents['status_code']) && $contents['status_code'] != 0) || empty($contents['item_list'][0]['video']['play_addr']['uri'])) {
            throw new ErrorVideoException("{DouYin} parsing failed");
        }

        $videoUrl = $this->redirects('https://aweme.snssdk.com/aweme/v1/play/', [
            'video_id' => $contents['item_list'][0]['video']['play_addr']['uri'],
            'ratio' => '1080',
            'line' => '0',
        ], [
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        return $this->returnData(
            $url,
            isset($contents['item_list'][0]['author']['nickname']) ? $contents['item_list'][0]['author']['nickname'] : '',
            isset($contents['item_list'][0]['author']['avatar_larger']['url_list'][0]) ? $contents['item_list'][0]['author']['avatar_larger']['url_list'][0] : '',
            isset($contents['item_list'][0]['desc']) ? $contents['item_list'][0]['desc'] : '',
            isset($contents['item_list'][0]['video']['cover']['url_list'][0]) ? $contents['item_list'][0]['video']['cover']['url_list'][0] : '',
            $videoUrl,
            'video'
        );
    }
}