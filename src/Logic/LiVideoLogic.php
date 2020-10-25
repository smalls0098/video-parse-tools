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

    private $videoId;

    public function setVideoId()
    {
        if (strpos($this->url, '?')) {
            preg_match('/_([0-9]+)\?st=/i', $this->url, $match);
        } else {
            preg_match('/_([0-9]+)/i', $this->url, $match);
        }
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("视频ID获取失败");
        }
        $this->videoId = $match[1];
    }

    public function setContents()
    {
        $contents = $this->get('https://www.pearvideo.com/videoStatus.jsp', [
            'contId' => $this->videoId
        ], [
            'Referer' => $this->url,
            'User-Agent' => UserGentType::WIN_USER_AGENT,
        ]);
        $this->contents = $contents;
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
        return isset($this->contents['videoInfo']['video_image']) ? $this->contents['videoInfo']['video_image'] : '';
    }

    public function getVideoUrl()
    {
        if (isset($this->contents['videoInfo']['videos']['srcUrl']) && isset($this->contents['systemTime'])) {
            return str_replace($this->contents['systemTime'], "cont-" . $this->videoId, $this->contents['videoInfo']['videos']['srcUrl']);
        }
        return '';
    }


}