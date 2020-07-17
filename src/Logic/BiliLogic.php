<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Enumerates\BiliQualityType;
use Smalls\VideoTools\Enumerates\UserGentType;
use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Utils\CommonUtil;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/10 - 12:50
 **/
class BiliLogic extends Base
{

    private $cookie = '';
    private $quality = BiliQualityType::LEVEL_5;
    private $aid;
    private $cid;
    private $contents;

    /**
     * BiliLogic constructor.
     * @param $url
     * @param string $cookie
     * @param int $quality
     * @param $urlList
     * @param $config
     */
    public function __construct($url, string $cookie, int $quality, $urlList, $config)
    {
        $this->cookie  = $cookie;
        $this->quality = $quality;
        $this->url     = $url;
        $this->urlList = $urlList;
        $this->config  = $config;
    }

    public function setAidAndCid()
    {
        $contents = $this->get($this->url, [], [
            'User-Agent' => UserGentType::WIN_USER_AGENT
        ]);
        preg_match('/"aid":([0-9]+),/i', $contents, $aid);
        preg_match('/"cid":([0-9]+),/i', $contents, $cid);
        if (CommonUtil::checkEmptyMatch($aid) || CommonUtil::checkEmptyMatch($cid)) {
            throw new ErrorVideoException("aid或cid获取不到参数");
        }
        $this->aid = $aid[1];
        $this->cid = $cid[1];
    }

    public function setContents()
    {
        $apiUrl         = 'https://api.bilibili.com/x/player/playurl';
        $contents       = $this->get($apiUrl, [
            'avid'  => $this->aid,
            'cid'   => $this->cid,
            'qn'    => $this->quality,
            'otype' => 'json',
        ], [
            'Cookie'     => $this->cookie,
            'Referer'    => $apiUrl,
            'User-Agent' => UserGentType::WIN_USER_AGENT
        ]);
        $this->contents = $contents;
    }

    /**
     * @return string
     */
    public function getCookie(): string
    {
        return $this->cookie;
    }

    /**
     * @return int
     */
    public function getQuality(): int
    {
        return $this->quality;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getAid()
    {
        return $this->aid;
    }

    /**
     * @return mixed
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
    }

    public function getVideoUrl()
    {
        return isset($this->contents['data']['durl'][0]['url']) ? $this->contents['data']['durl'][0]['url'] : '';
    }

    public function getVideoImage()
    {
        return '';
    }

    public function getVideoDesc()
    {
        return '';
    }

    public function getUsername()
    {
        return '';
    }

    public function getUserPic()
    {
        return '';
    }


}