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
 * Date：2020/6/10 - 16:41
 **/
class LiVideoLogic extends Base
{

    private $contents;
    private $VideoUrl;


    public function setContents()
    {
        $contents = $this->get($this->url, [], [
            'User-Agent' => UserGentType::WIN_USER_AGENT,
        ]);
        $this->contents = $contents;
    }

    public function setVideoUrl()
    {
        preg_match('/srcUrl="(.*?)",/i', $this->contents, $videoMatches);

        if (CommonUtil::checkEmptyMatch($videoMatches)) {
            throw new ErrorVideoException("视频URL获取失败");
        }
        $this->VideoUrl = $videoMatches[1];
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getUsername()
    {
        return '';
    }

    public function getUserPic()
    {
        return '';
    }

    public function getVideoDesc()
    {
        return '';
    }

    public function getVideoImage()
    {
        return '';
    }

    public function getVideoUrl()
    {
        return $this->VideoUrl;
    }


}