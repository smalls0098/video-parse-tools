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
 * Date：2020/6/9 - 18:22
 **/
class XiaoKaXiuLogic
{
    use HttpRequest;

    private $url;
    private $contents;
    private $videoId;

    /**
     * HuoShanLogic constructor.
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

        if (strpos($this->url, "mobile.xiaokaxiu.com") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
    }

    public function setVideoId()
    {
        preg_match('/video\?id=([0-9]+)/i', $this->url, $itemMatches);

        if (CommonUtil::checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("url parsing failed");
        }
        $this->videoId = $itemMatches[1];
    }

    public function setContents()
    {
        list($time, $sign) = $this->makeSign();
        $newGetContentUrl = 'https://appapi.xiaokaxiu.com/api/v1/web/share/video/' . $this->videoId;
        $contents = $this->get($newGetContentUrl, [
            'time' => $time,
        ], [
            'Referer' => $newGetContentUrl,
            'x-sign' => $sign,
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        if (isset($contents['code']) && $contents['code'] != 0) {
            throw new ErrorVideoException("contents parsing failed");
        }
        $this->contents = $contents;
    }

    private function makeSign()
    {
        $time = time();
        $sign = md5("S14OnTD#Qvdv3L=3vm&time=" . $time);
        return [$time, $sign];
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

    public function getVideoUrl()
    {
        return CommonUtil::getData($this->contents['data']['video']['url'][0]);
    }


    public function getVideoImage()
    {
        return CommonUtil::getData($this->contents['data']['video']['cover']);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->contents['data']['video']['title']);
    }

    public function getUserPic()
    {
        return '';
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->contents['data']['video']['user']['nickname']);
    }


}