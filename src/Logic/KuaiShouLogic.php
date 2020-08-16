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
    
    private $contents;

    /**
     *
     * @throws ErrorVideoException
     */
    public function setContents()
    {
        $data = [
            'client_key' => '3c2cd3f3',
            'shareText'  => $this->url,
            'appver'     => '6.9.2.11245',//6.9.2.11245  7.7.10.15712
            'did'        => 'ANDROID_c45e742737e8' . rand(1000, 9999),
        ];
        $salt = "382700b563f4";
        ksort($data);
        $str         = http_build_query($data);
        $str         = urldecode($str);
        $str         = str_replace('&', '', $str) . $salt;
        $md5         = md5($str);
        $data['sig'] = $md5;
        //https://api.kuaishouzt.com/rest/zt/share/show/any?mod=oppo%28oppo%20a33m%29&lon=116.469144&subBiz=share&userId=2010791230&kpf=ANDROID_PHONE&did=ANDROID_b2b37711742e41e3&kpn=KUAISHOU&net=WIFI&os=android&gid=DFP0033387ED2BF796BA6683B22488809F1D576E7CA3403872B4BB64DAF0DA67&countryCode=cn&c=GENERIC&sys=ANDROID_5.1.1&appver=7.7.10.15712&language=zh-cn&lat=39.902831&ver=7.7
        $contents    = $this->post('http://api.gifshow.com/rest/n/tokenShare/info/byText', $data, [
            'User-Agent' => 'kwai-android',
        ]);
        if (isset($contents['result']) && $contents['result'] != 1) {
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