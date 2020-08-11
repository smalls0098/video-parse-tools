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
 * Date：2020/8/5 - 16:21
 **/
class H5KuaiShouLogic extends Base
{

    private $contents;


    public function setContents()
    {
        $res = $this->get($this->url, [], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
            'Cookie'     => $this->toolsObj->getCookie()
        ]);
        preg_match('/window\.pageData= ([\s\S]*?)<\/script>/i', $res, $matches);
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("contents获取不到");
        }
        $this->contents = json_decode($matches[1], true);
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
        return isset($this->contents['video']['srcNoMark']) ? $this->contents['video']['srcNoMark'] : '';
    }

    public function getVideoImage()
    {
        return isset($this->contents['video']['poster']) ? $this->contents['video']['poster'] : '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['video']['caption']) ? $this->contents['video']['caption'] : '';
    }

    public function getUsername()
    {
        return isset($this->contents['user']['avatar']) ? $this->contents['user']['avatar'] : '';

    }

    public function getUserPic()
    {
        return isset($this->contents['user']['name']) ? $this->contents['user']['name'] : '';

    }


}