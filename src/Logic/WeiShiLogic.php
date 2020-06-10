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
 * Date：2020/6/10 - 14:13
 **/
class WeiShiLogic extends Base
{

    private $feedId;
    private $contents;


    public function setFeedId()
    {
        preg_match('/feed\/(.*?)\/wsfeed/i', $this->url, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("feed_id参数获取失败");
        }
        $this->feedId = $match[1];
    }

    public function setContents()
    {
        $contents = $this->post('https://h5.qzone.qq.com/webapp/json/weishi/WSH5GetPlayPage?t=0.4185745904612037&g_tk=', [
            'feedid' => $this->feedId,
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT
        ]);
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getFeedId()
    {
        return $this->feedId;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents['data']['feeds'][0];
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
        return CommonUtil::getData($this->getContents()['video_url']);
    }


    public function getVideoImage()
    {
        return CommonUtil::getData($this->getContents()['images'][0]['url']);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->getContents()['share_info']['body_map'][0]['desc']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->getContents()['poster']['nick']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->getContents()['poster']['avatar']);
    }


}