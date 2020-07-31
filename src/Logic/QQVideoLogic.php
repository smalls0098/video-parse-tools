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
 * Date：2020/7/17 - 16:16
 **/
class QQVideoLogic extends Base
{

    private $vid;
    /**
     * @var array
     */
    private $contents;

    public function setVid()
    {
        if (!strpos($this->url, 'play/play.html')) {
            throw new ErrorVideoException('获取不到vid');
        }
        preg_match('/vid=(.*?)&/i', $this->url, $matches);
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("获取不到vid参数信息");
        }
        $this->vid = $matches[1];
    }

    public function setContents()
    {
        $contents = $this->get('https://h5vv6.video.qq.com/getinfo', [
            'vid'       => $this->vid,
            'show1080p' => "true",
            'platform'  => "11001",
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        if (empty($contents['vl']['vi'])) {
            throw new ErrorVideoException("获取不到内容信息");
        }
        $this->contents = $contents['vl']['vi'];
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
        $fn    = $this->contents['fn'];
        $fvkey = $this->contents['fvkey'];
        $url   = $this->contents['ul']['ui'][0]['url'];
        return $url . $fn . '?fvkey=' . $fvkey;
    }


    public function getVideoImage()
    {
        return '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['ti']) ? $this->contents['ti'] : '';
    }

    public function getUserPic()
    {
        return '';
    }

    public function getUsername()
    {
        return '';
    }


}