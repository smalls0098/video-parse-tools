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
        if (!$this->toolsObj->getCookie()) {
            $cookie = $this->getCookie($this->url, [
                'User-Agent' => UserGentType::ANDROID_USER_AGENT,
            ]);
            preg_match('/did=(web_.*?);/', $cookie, $matches);
            if (CommonUtil::checkEmptyMatch($matches)) {
                throw new ErrorVideoException("did获取不到");
            }
            $did = $matches[1];
            preg_match('/client_key=(.*?);/', $cookie, $matches);
            if (CommonUtil::checkEmptyMatch($matches)) {
                throw new ErrorVideoException("client_key获取不到");
            }
            $clientKey = $matches[1];
            preg_match('/clientid=([0-9]);/', $cookie, $matches);
            $clientId = isset($matches[1]) ? $matches[1] : 3;
            $cookie   = 'did=' . $did . '; client_key=' . $clientKey . '; clientid=' . $clientId . '; didv=' . time() . '000;';
        } else {
            $cookie = $this->toolsObj->getCookie();
        }
        $res = $this->get($this->url, [], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
            'Cookie'     => $cookie
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