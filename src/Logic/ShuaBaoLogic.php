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
class ShuaBaoLogic
{
    use HttpRequest;

    private $url;
    private $contents;
    private $showId;

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

        if (strpos($this->url, "shua8cn.com/video_share") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
    }

    public function setShowId()
    {
        preg_match('/show_id=(.*?)&/i', $this->url, $itemMatches);

        if (CommonUtil::checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("url parsing failed");
        }
        $this->showId = $itemMatches[1];
    }

    public function setContents()
    {
        $contents = $this->get('http://h5.shua8cn.com/api/video/detail', [
            'show_id' => $this->showId,
            'provider' => 'weixin',
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        if (isset($contents['code']) && $contents['code'] != "0") {
            throw new ErrorVideoException("contents parsing failed");
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
    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl()
    {
        return CommonUtil::getData($this->contents['data']['video_url']);
    }


    public function getVideoImage()
    {
        return CommonUtil::getData($this->contents['data']['cover_pic']['720']);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->contents['data']['description']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->contents['data']['user_info']['avatar']['720']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->contents['data']['user_info']['nickname']);
    }


}