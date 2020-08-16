<?php

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Enumerates\UserGentType;
use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Utils\CommonUtil;

/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/8/13 - 22:52
 **/
class TaoBaoLogic extends Base
{

    private $contents;

    public function setContents()
    {
        $res = $this->get($this->url, [], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        preg_match('/var url = \'(.*?)\';/i', $res, $matches);
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("获取不到url信息");
        }
        $url = $matches[1];
        preg_match('/i([0-9]+)\.htm/', $url, $matches);

        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("获取不到itemid信息");
        }

        $data = [
            'itemNumId' => (string)$matches[1]
        ];

        $res = $this->get('https://h5api.m.taobao.com/h5/mtop.taobao.detail.getdetail/6.0/', [
            'data' => json_encode($data)
        ], [
            'referer' => $url,
        ]);
        if (empty($res['data']['apiStack'][0]['value'])) {
            throw new ErrorVideoException("获取不到value信息");
        }

        $data = json_decode($res['data']['apiStack'][0]['value'], true);
        if (isset($data['item']['videos'][0])) {
            $this->contents = $data['item']['videos'][0];
        } else if (empty($data['item']['videoDetail'][0])) {
            $this->contents = $data['item']['videoDetail'][0];
        } else {
            throw new ErrorVideoException("获取不到videos or videoDetail信息");
        }
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
        return isset($this->contents['url']) ? $this->contents['url'] : '';
    }

    public function getVideoImage()
    {
        return isset($this->contents['videoThumbnailURL']) ? $this->contents['videoThumbnailURL'] : '';
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