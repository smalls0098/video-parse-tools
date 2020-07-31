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
 * Date：2020/6/10 - 18:22
 **/
class XiaoKaXiuLogic extends Base
{

    private $contents;
    private $videoId;

    public function setVideoId()
    {
        preg_match('/video\?id=([0-9]+)/i', $this->url, $itemMatches);

        if (CommonUtil::checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("获取不到video_id参数信息");
        }
        $this->videoId = $itemMatches[1];
    }

    public function setContents()
    {
        list($time, $sign) = $this->makeSign();
        $newGetContentUrl = 'https://appapi.xiaokaxiu.com/api/v1/web/share/video/' . $this->videoId;
        $contents         = $this->get($newGetContentUrl, [
            'time' => $time,
        ], [
            'Referer'    => $newGetContentUrl,
            'x-sign'     => $sign,
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        if (isset($contents['code']) && $contents['code'] != 0) {
            throw new ErrorVideoException("获取不到指定的内容信息");
        }
        $this->contents = $contents;
    }

    private function makeSign()
    {
        $time = time();
        $sign = md5("S14OnTD#Qvdv3L=3vm&time=" . $time);
        return [$time, $sign];
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
        return isset($this->contents['data']['video']['url'][0]) ? $this->contents['data']['video']['url'][0] : '';
    }


    public function getVideoImage()
    {
        return isset($this->contents['data']['video']['cover']) ? $this->contents['data']['video']['cover'] : '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['data']['video']['title']) ? $this->contents['data']['video']['title'] : '';
    }

    public function getUserPic()
    {
        return '';
    }

    public function getUsername()
    {
        return isset($this->contents['data']['video']['user']['nickname']) ? $this->contents['data']['video']['user']['nickname'] : '';
    }


}