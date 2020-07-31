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
class ShuaBaoLogic extends Base
{

    private $contents;
    private $showId;


    public function setShowId()
    {
        if (strpos($this->url, 'm.shua8cn.com') > -1) {
            $res = $this->redirects($this->url);
            if (strpos($res, 'h5.shua8cn.com') > -1) {
                $this->url = $res;
            } else {
                throw new ErrorVideoException("提交的域名不符合格式");
            }
        }
        preg_match('/show_id=(.*?)&/i', $this->url, $itemMatches);

        if (CommonUtil::checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("获取不到show_id参数信息");
        }
        $this->showId = $itemMatches[1];
    }

    public function setContents()
    {
        $contents = $this->get('http://h5.shua8cn.com/api/video/detail', [
            'show_id'  => $this->showId,
            'provider' => 'weixin',
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        if (isset($contents['code']) && $contents['code'] != "0") {
            throw new ErrorVideoException("获取不到指定的内容信息");
        }

        $this->contents = $contents;
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
        return isset($this->contents['data']['video_url']) ? $this->contents['data']['video_url'] : '';
    }


    public function getVideoImage()
    {
        return isset($this->contents['data']['cover_pic']['720']) ? $this->contents['data']['cover_pic']['720'] : '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['data']['description']) ? $this->contents['data']['description'] : '';
    }

    public function getUserPic()
    {
        return isset($this->contents['data']['user_info']['avatar']['720']) ? $this->contents['data']['user_info']['avatar']['720'] : '';
    }

    public function getUsername()
    {
        return isset($this->contents['data']['user_info']['nickname']) ? $this->contents['data']['user_info']['nickname'] : '';
    }


}