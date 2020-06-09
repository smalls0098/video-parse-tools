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
 * Date：2020/6/9 - 16:41
 **/
class LiVideoLogic
{

    use HttpRequest;

    private $url;
    private $contents;
    private $VideoUrl;

    /**
     * LiVideoLogic constructor.
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

        if (strpos($this->url, "www.pearvideo.com") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
    }

    public function setContents()
    {
        $contents = $this->get($this->url, [], [
            'User-Agent' => UserGentType::WIN_USER_AGENT,
        ]);
        $this->contents = $contents;
    }

    public function setVideoUrl()
    {
        preg_match('/srcUrl="(.*?)",/i', $this->contents, $videoMatches);

        if (CommonUtil::checkEmptyMatch($videoMatches)) {
            throw new ErrorVideoException("parsing failed");
        }
        $this->VideoUrl = $videoMatches[1];
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getUsername()
    {
        return '';
    }

    public function getUserPic()
    {
        return '';
    }

    public function getVideoDesc()
    {
        return '';
    }

    public function getVideoImage()
    {
        return '';
    }

    public function getVideoUrl()
    {
        return $this->VideoUrl;
    }


}