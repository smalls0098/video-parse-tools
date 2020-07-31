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
class WeiBoLogic extends Base
{

    private $statusId;
    private $contents;

    public function setStatusId()
    {
        if (strpos($this->url, 'weibo.com/tv/v')) {
            preg_match('/tv\/v\/(.*?)$/i', $this->url, $matches);
        } elseif (strpos($this->url, 'weibo.cn')) {
            preg_match('/\/([0-9]+)$/i', $this->url, $matches);
        } else {
            throw new ErrorVideoException("获取不到指定的参数信息");
        }
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("获取不到statusId参数信息");
        }
        $this->statusId = $matches[1];
    }

    public function setContents()
    {
        $statusId = $this->getStatusId();
        if (empty($statusId)) {
            throw new ErrorVideoException("获取不到statusId参数信息");
        }
        $url      = 'https://m.weibo.cn/status/' . $statusId;
        $contents = $this->get($url, [
            'jumpfrom' => 'weibocom'
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        preg_match('/render_data = \[({[\S\s]+)\]\[0\]/i', $contents, $matches);
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("获取不到内容信息");
        }
        $this->contents = json_decode($matches[1], true);
    }

    private function getContents()
    {
        return $this->contents;
    }

    /**
     * @return mixed
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl()
    {
        return isset($this->contents['status']['page_info']['media_info']['stream_url_hd']) ? $this->contents['status']['page_info']['media_info']['stream_url_hd'] : '';
    }

    public function getVideoImage()
    {
        return isset($this->contents['status']['page_info']['page_pic']['url']) ? $this->contents['status']['page_info']['page_pic']['url'] : '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['status']['page_info']['title']) ? $this->contents['status']['page_info']['title'] : '';
    }

    public function getUsername()
    {
        return isset($this->contents['status']['user']['screen_name']) ? $this->contents['status']['user']['screen_name'] : '';
    }

    public function getUserPic()
    {
        return isset($this->contents['status']['user']['profile_image_url']) ? $this->contents['status']['user']['profile_image_url'] : '';
    }

}