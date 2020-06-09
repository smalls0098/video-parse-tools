<?php

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Enumerates\UserGentType;
use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Traits\HttpRequest;
use Smalls\VideoTools\Utils\CommonUtil;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/9 - 14:00
 **/
class TouTiaoLogic
{
    use HttpRequest;

    private $url;
    private $itemId;
    private $contents;

    /**
     * KuaiShouLogic constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }


    public function checkUrlHasTrue()
    {
        if (empty($this->url)) {
            throw new ErrorVideoException("url cannot be empty");
        }
        if (strpos($this->url, "toutiaoimg.com") == false && strpos($this->url, "toutiaoimg.cn") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
    }

    public function setItemId()
    {
        preg_match('/a([0-9]+)\/?/i', $this->url, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("url parsing failed");
        }
        $this->itemId = $match[1];
    }

    public function setContents($itemId = '')
    {
        if ($itemId) {
            $this->itemId = $itemId;
        }
        $getContentUrl = 'https://m.365yg.com/i' . $this->itemId . '/info/';

        $contents = $this->get($getContentUrl, ['i' => $this->itemId], [
            'Referer' => $getContentUrl,
            'User-Agent' => UserGentType::ANDROID_USER_AGENT
        ]);

        if (empty($contents['data']['video_id'])) {
            throw new ErrorVideoException("contents parsing failed");
        }
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl(): string
    {
        return $this->redirects('http://hotsoon.snssdk.com/hotsoon/item/video/_playback/', [
            'video_id' => $this->contents['data']['video_id'],
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT
        ]);
    }

    public function getVideoImage()
    {
        return CommonUtil::getData($this->contents['data']['poster_url']);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->contents['data']['title']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->contents['data']['media_user']['screen_name']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->contents['data']['media_user']['avatar_url']);
    }

}