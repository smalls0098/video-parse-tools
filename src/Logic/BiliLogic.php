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
     * BiliLogic初始化.
     * @param string $cookie
     * @param int $quality
     */
    public function init(string $cookie, int $quality)
    {
        $this->cookie  = $cookie;
        $this->quality = $quality;
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
            'type'  => 'mp4',
            'platform' => 'html5',
        ], [
            'Cookie'     => $this->cookie,
            'Referer'    => 'https://m.bilibili.com/video/av84665662',
            'origin'    => 'https://m.bilibili.com',
            'Host'    => 'api.bilibili.com',
            'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_5_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 MicroMessenger/7.0.14(0x17000e29) NetType/WIFI Language/zh_CN',
        ]);
        $this->contents = $contents;
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