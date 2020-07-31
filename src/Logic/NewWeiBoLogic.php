<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Enumerates\UserGentType;
use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Utils\CommonUtil;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/13 - 21:05
 **/
class NewWeiBoLogic extends Base
{

    private $fid;
    private $mid;
    private $contents;


    public function setMid()
    {
        $url = $this->redirects('https://video.weibo.com/show', [
            'fid' => $this->fid,
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT
        ]);
        if (!$url) {
            throw new ErrorVideoException("获取不到Url信息");
        }
        preg_match('/([0-9]+)$/i', $url, $matches);
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("获取不到mid参数信息");
        }
        $this->mid = $matches[1];
    }

    public function setFid()
    {
        preg_match('/show\?fid=([0-9]+):([0-9]+)/i', $this->url, $matches);
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("获取不到FId参数信息");
        }
        $this->fid = $matches[1] . ':' . $matches[2];
    }

    public function setContents()
    {
        $url            = 'https://video.h5.weibo.cn/s/video/object';
        $contents       = $this->get($url, [
            'object_id' => $this->fid,
            'mid'       => $this->mid,
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        $this->contents = $contents;
    }

    private function getContents()
    {
        return $this->contents;
    }

    /**
     * @return mixed
     */
    public function getFid()
    {
        return $this->fid;
    }

    /**
     * @return mixed
     */
    public function getMid()
    {
        return $this->mid;
    }


    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl()
    {
        return isset($this->contents['data']['object']['stream']['hd_url']) ? $this->contents['data']['object']['stream']['hd_url'] : '';
    }

    public function getVideoImage()
    {
        return isset($this->contents['data']['object']['image']['url']) ? $this->contents['data']['object']['image']['url'] : '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['data']['object']['summary']) ? $this->contents['data']['object']['summary'] : '';
    }

    public function getUsername()
    {
        return isset($this->contents['data']['object']['author']['screen_name']) ? $this->contents['data']['object']['author']['screen_name'] : '';
    }

    public function getUserPic()
    {
        return isset($this->contents['data']['object']['author']['profile_image_url']) ? $this->contents['data']['object']['author']['profile_image_url'] : '';
    }

}