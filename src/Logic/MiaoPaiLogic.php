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
 * Date：2020/6/10 - 14:51
 **/
class MiaoPaiLogic extends Base
{


    private $contents;

    private $mid;

    public function setMid()
    {
        if (!strpos($this->url, 'n.miaopai.com/media')) {
            $url = $this->redirects($this->url, [], [
                'User-Agent' => UserGentType::WIN_USER_AGENT,
            ]);
        } else {
            $url = $this->url;
        }
        preg_match('/\/media\/(.*?)$/i', $url, $matches);
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("获取不到mid信息");
        }
        $matches[1] = str_replace(['.htm', '.html'], '', $matches[1]);
        $this->mid  = $matches[1];
    }

    public function setContents()
    {
        $callback       = '_jsonp' . (string)time();
        $contents       = $this->get('http://n.miaopai.com/api/aj_media/info.json', [
            'smid'  => $this->getMid(),
            'appid' => '530',
            '_cb'   => $callback,
        ], [
            'User-Agent' => UserGentType::WIN_USER_AGENT,
            'Referer'    => 'http://n.miaopai.com/media/' . $this->getMid(),
        ]);
        $contents       = str_replace("window." . $callback . " && " . $callback . "(", '', $contents);
        $contents       = str_replace(");", '', $contents);
        $contents       = json_decode($contents, true);
        $this->contents = $contents;
    }


    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getMid()
    {
        return $this->mid;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
    }


    public function getVideoUrl()
    {
        return isset($this->contents['data']['meta_data'][0]['play_urls']['l']) ? $this->contents['data']['meta_data'][0]['play_urls']['l'] : '';
    }

    public function getVideoImage()
    {
        return isset($this->contents['data']['meta_data'][0]['pics']['interlace']) ? $this->contents['data']['meta_data'][0]['pics']['interlace'] : '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['data']['description']) ? $this->contents['data']['description'] : '';

    }

    public function getUsername()
    {
        return isset($this->contents['data']['user']['nick']) ? $this->contents['data']['user']['nick'] : '';
    }

    public function getUserPic()
    {
        return isset($this->contents['data']['user']['avatar']) ? $this->contents['data']['user']['avatar'] : '';
    }

}