<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Exception\ErrorVideoException;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/10 - 13:24
 **/
class KuaiShouLogic extends Base
{

    private $match;
    private $contents;

    /**
     * 多了可能是短时间kuaishou屏蔽IP
     * @throws ErrorVideoException
     */
    public function setContents()
    {
        $data = [
            'client_key' => '3c2cd3f3',
            'shareText'  => $this->url,
            'appver'     => '6.9.2.11245',
            'did'        => 'ANDROID_c45e742737e8' . rand(1000, 9999),
        ];
        $salt = "382700b563f4";
        ksort($data);
        $str         = http_build_query($data);
        $str         = urldecode($str);
        $str         = str_replace('&', '', $str) . $salt;
        $md5         = md5($str);
        $data['sig'] = $md5;
        $contents    = $this->post('http://api.gifshow.com/rest/n/tokenShare/info/byText', $data, [
            'User-Agent' => 'kwai-android',
        ]);
        if (isset($contents['result']) && $contents['result'] == 50) {
            throw new ErrorVideoException($contents['error_msg']);
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
        return isset($this->contents['shareTokenDialog']['feed']['main_mv_urls'][0]['url']) ? $this->contents['shareTokenDialog']['feed']['main_mv_urls'][0]['url'] : '';
    }

    public function getVideoImage()
    {
        return isset($this->contents['shareTokenDialog']['feed']['cover_thumbnail_urls'][0]['url']) ? $this->contents['shareTokenDialog']['feed']['cover_thumbnail_urls'][0]['url'] : '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['shareTokenDialog']['feed']['caption']) ? $this->contents['shareTokenDialog']['feed']['caption'] : '';
    }

    public function getUsername()
    {
        return isset($this->contents['shareTokenDialog']['feed']['user_name']) ? $this->contents['shareTokenDialog']['feed']['user_name'] : '';

    }

    public function getUserPic()
    {
        return isset($this->contents['shareTokenDialog']['feed']['headurls'][0]['url']) ? $this->contents['shareTokenDialog']['feed']['headurls'][0]['url'] : '';

    }


}