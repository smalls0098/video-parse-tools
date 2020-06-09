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
 * Date：2020/6/9 - 13:05
 **/
class DouYinLogic
{

    use HttpRequest;

    private $url;
    private $contents;
    private $dyTkId;
    private $itemId;

    /**
     * DouYinLogic constructor.
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
        if (strpos($this->url, "douyin.com") == false && strpos($this->url, "iesdouyin.com") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
    }

    public function setDyTksAndItemIds()
    {
        $contents = $this->get($this->url, [], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        preg_match('/dytk:[^+]"(.*?)"[^+]}\);/i', $contents, $dyTks);
        preg_match('/itemId:[^+]"(.*?)",/i', $contents, $itemIds);
        if (CommonUtil::checkEmptyMatch($dyTks) || CommonUtil::checkEmptyMatch($itemIds)) {
            throw new ErrorVideoException("dyTk or itemId is empty, there may be a problem with the website");
        }
        $this->dyTkId = $dyTks[1];
        $this->itemId = $itemIds[1];
    }

    public function setContents()
    {
        $contents = $this->get('https://www.iesdouyin.com/web/api/v2/aweme/iteminfo', [
            'item_ids' => $this->itemId,
            'dytk' => $this->dyTkId,
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
            'Referer' => "https://www.iesdouyin.com",
            'Host' => "www.iesdouyin.com",
        ]);
        if ((isset($contents['status_code']) && $contents['status_code'] != 0) || empty($contents['item_list'][0]['video']['play_addr']['uri'])) {
            throw new ErrorVideoException("parsing failed");
        }
        if (empty($contents['item_list'][0])) {
            throw new ErrorVideoException("contents not exist item_list");
        }
        $this->contents = $contents;
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
    public function getDyTkId()
    {
        return $this->dyTkId;
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
        if (empty($this->contents['item_list'][0]['video']['play_addr']['uri'])) {
            return '';
        }
        return $this->redirects('https://aweme.snssdk.com/aweme/v1/play/', [
            'video_id' => $this->contents['item_list'][0]['video']['play_addr']['uri'],
            'ratio' => '1080',
            'line' => '0',
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
    }

    public function getVideoImage()
    {
        return CommonUtil::getData($this->contents['item_list'][0]['video']['cover']['url_list'][0]);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->contents['item_list'][0]['desc']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->contents['item_list'][0]['author']['nickname']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->contents['item_list'][0]['author']['avatar_larger']['url_list'][0]);
    }

}