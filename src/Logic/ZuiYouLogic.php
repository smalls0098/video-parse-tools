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
class ZuiYouLogic
{

    use HttpRequest;

    private $url;
    private $pid;
    private $contents;
    private $id;

    /**
     * ZuiYouLogic constructor.
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

        if (strpos($this->url, "izuiyou.com") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
    }

    public function setPId()
    {
        preg_match('/detail\/([0-9]+)\/?/i', $this->url, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("url parsing failed");
        }
        $this->pid = $match[1];
    }

    public function setContents()
    {
        $newGetContentsUrl = 'https://share.izuiyou.com/api/post/detail';
        $contents = $this->post($newGetContentsUrl, '{"pid":' . $this->pid . '}', [
            'Referer' => $newGetContentsUrl,
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        $this->contents = $contents;
    }

    public function parseId()
    {
        $contents = $this->contents;
        if ((isset($contents['ret']) && $contents['ret'] != 1) || (isset($contents['data']['post']['imgs'][0]['id']) && $contents['data']['post']['imgs'][0]['id'] == null)) {
            throw new ErrorVideoException("contents parsing failed");
        }
        $id = $contents['data']['post']['imgs'][0]['id'];
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents['data']['post'];
    }

    /**
     * @return mixed
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
        return CommonUtil::getData($this->getContents()['videos'][$this->id]['url']);
    }


    public function getVideoImage()
    {
        $id = CommonUtil::getData($this->getContents()['imgs'][0]['id']);
        if ($id) {
            return 'http://tbfile.izuiyou.com/img/frame/id/' . $id;
        }
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->getContents()['content']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->getContents()['member']['name']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->getContents()['member']['avatar_urls']['aspect_low']['urls'][0]);
    }


}