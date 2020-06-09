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
class PiPiGaoXiaoLogic
{
    use HttpRequest;

    private $url;
    private $postId;
    private $contents;

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

        if (strpos($this->url, "ippzone.com") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
    }

    public function setPostId()
    {
        preg_match('/pp\/post\/([0-9]+)/i', $this->url, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("url parsing failed");
        }
        $this->postId = $match[1];
    }

    public function setContents()
    {
        $newGetContentsUrl = 'http://share.ippzone.com/ppapi/share/fetch_content';
        $contents = $this->post($newGetContentsUrl, '{"pid":' . $this->postId . ',"type":"post","mid":null}', [
            'Referer' => $newGetContentsUrl,
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        if ((isset($contents['ret']) && $contents['ret'] != 1) || (isset($contents['data']['post']['imgs'][0]['id']) && !$contents['data']['post']['imgs'][0]['id'])) {
            throw new ErrorVideoException("{PiPiGaoXiao} contents parsing failed");
        }
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->postId;
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
        $id = CommonUtil::getData($this->contents['data']['post']['imgs'][0]['id']);
        if ($id) {
            return CommonUtil::getData($this->contents['data']['post']['videos'][$id]['url']);
        }
        return '';
    }


    public function getVideoImage()
    {
        $id = CommonUtil::getData($this->contents['data']['post']['imgs'][0]['id']);
        if ($id) {
            return "https://file.ippzone.com/img/view/id/{$id}";
        }
        return '';
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->contents['data']['post']['content']);
    }

    public function getUserPic()
    {
        return '';
    }

    public function getUsername()
    {
        return '';
    }


}