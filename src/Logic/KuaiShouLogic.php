<?php

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Enumerates\UserGentType;
use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Traits\HttpRequest;
use Smalls\VideoTools\Utils\CommonUtil;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/9 - 13:24
 **/
class KuaiShouLogic
{

    use HttpRequest;

    private $url;
    private $match;
    private $contents;

    /**
     * KuaiShouLogic constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }


    public function checkUrlHasTrue()
    {
        if (empty($this->url)) {
            throw new ErrorVideoException("url cannot be empty");
        }
        if (strpos($this->url, "ziyang.m.kspkg.com") == false && strpos($this->url, "kuaishou.com") == false && strpos($this->url, "gifshow.com") == false && strpos($this->url, "chenzhongtech.com") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
    }

    public function setContents()
    {
        $time = time();
        $did = md5($this->did());
        $contents = $this->get($this->url, [
            'did' => 'web_' . $did
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT . ' ' . $did,
            'cookie' => 'did=web_' . $did . '; didv=' . $time . '000; clientid=3; client_key=65890b29',
        ]);

        preg_match('/data-pagedata="(.*?)"/i', $contents, $this->match);
        if (CommonUtil::checkEmptyMatch($this->match)) {
            throw new ErrorVideoException("contents parsing failed");
        }
    }

    public function formatData()
    {
        $contents = htmlspecialchars_decode($this->match[1]);
        if (!$contents || $contents == NULL) {
            throw new ErrorVideoException("content is null");
        }
        $this->contents = json_decode($contents, true);
    }

    public function did()
    {
        $rand = $this->random();
        $e = (1e9 * $rand) >> 0;
        $p = '0123456789ABCDEF';
        $s = "";
        for ($i = 0; $i < 7; $i++) {
            $s .= $p{16 * $this->random()};
        }
        return $e . $s;
    }

    private function random()
    {
        return 0 + mt_rand() / mt_getrandmax() * (1 - 0);
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
        return CommonUtil::getData($this->contents['video']['srcNoMark']);
    }

    public function getVideoImage()
    {
        return CommonUtil::getData($this->contents['video']['poster']);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->contents['video']['caption']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->contents['user']['name']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->contents['user']['avatar']);
    }


}