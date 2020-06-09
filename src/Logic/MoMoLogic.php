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
class MoMoLogic
{
    use HttpRequest;

    private $url;
    private $contents;
    private $feedId;

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

        if (strpos($this->url, "immomo.com") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
    }

    public function setFeedId()
    {
        preg_match('/new-share-v2\/(.*?).html/i', $this->url, $itemMatches);
        if (CommonUtil::checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("url parsing failed");
        }
        $this->feedId = $itemMatches[1];
    }

    public function setContents()
    {
        $contents = $this->post('https://m.immomo.com/inc/microvideo/share/profiles', [
            'feedids' => $this->feedId
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);

        if (isset($contents['ec']) && $contents['ec'] != 200) {
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
        return CommonUtil::getData($this->contents['data']['list'][0]['video']['video_url']);
    }


    public function getVideoImage()
    {
        return CommonUtil::getData($this->contents['data']['list'][0]['video']['cover']['l']);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->contents['data']['list'][0]['video']['decorator_texts']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->contents['data']['list'][0]['user']['img']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->contents['data']['list'][0]['user']['name']);
    }


}