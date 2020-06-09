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
 * Date：2020/6/9 - 14:13
 **/
class PiPiXiaLogic
{

    use HttpRequest;

    private $url;
    private $itemId;
    private $contents;

    /**
     * PiPiXiaLogic constructor.
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

        if (strpos($this->url, "pipix.com") == false) {
            throw new ErrorVideoException("the URL must contain one of the domain names pipix.com to continue execution");
        }
    }

    public function setItemId()
    {
        $originalUrl = $this->redirects($this->url, [], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);

        preg_match('/item\/([0-9]+)\?/i', $originalUrl, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("originalUrl parsing failed");
        }
        $this->itemId = $match[1];
    }

    public function setContents()
    {
        $newGetContentsUrl = 'https://h5.pipix.com/bds/webapi/item/detail/';

        $contents = $this->get($newGetContentsUrl, [
            'item_id' => $this->itemId,
        ], [
            'Referer' => $newGetContentsUrl,
            'User-Agent' => UserGentType::ANDROID_USER_AGENT
        ]);

        if (empty($contents['data']['item'])) {
            throw new ErrorVideoException("contents parsing failed");
        }
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents['data']['item'];
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
    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl()
    {
        return CommonUtil::getData($this->getContents()['video']['video_fallback']['url_list'][0]['url']);
    }


    public function getVideoImage()
    {
        return CommonUtil::getData($this->getContents()['video']['cover_image']['url_list'][0]['url']);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->getContents()['share']['title']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->getContents()['author']['avatar']['url_list'][0]['url']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->getContents()['author']['name']);
    }


}