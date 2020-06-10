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
 * Date：2020/6/10 - 13:24
 **/
class KuaiShouLogic extends Base
{

    private $match;
    private $contents;

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
            throw new ErrorVideoException("获取不到指定的内容信息");
        }
    }

    public function formatData()
    {
        $contents = htmlspecialchars_decode($this->match[1]);
        if (!$contents || $contents == NULL) {
            throw new ErrorVideoException("内容为空");
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