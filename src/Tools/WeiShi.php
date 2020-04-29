<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;
/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 21:57
 **/

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;

class WeiShi extends Base implements IVideo
{


    public function __construct($params)
    {
    }

    /**
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{WeiShi} url cannot be empty");
        }

        if (strpos($url, "weishi.qq.com") == false) {
            throw new ErrorVideoException("{WeiShi} the URL must contain one of the domain names weishi.qq.com to continue execution");
        }

        preg_match('/feed\/(.*?)\/wsfeed/i', $url, $match);
        if ($this->checkEmptyMatch($match)) {
            throw new ErrorVideoException("{TouTiao} url parsing failed");
        }

        $contents = $this->post('https://h5.qzone.qq.com/webapp/json/weishi/WSH5GetPlayPage?t=0.4185745904612037&g_tk=', [
            'feedid' => $match[1],
        ], [
            'User-Agent' => self::ANDROID_USER_AGENT
        ]);

        if(empty($contents['data']['feeds'][0])) {
            throw new ErrorVideoException("{TouTiao} contents parsing failed");
        }
        $videoArr = $contents['data']['feeds'][0];
        return $this->returnData(
            $url,
            isset($videoArr['poster']['nick']) ? $videoArr['poster']['nick'] : '',
            isset($videoArr['poster']['avatar']) ? $videoArr['poster']['avatar'] : '',
            isset($videoArr['share_info']['body_map'][0]['desc']) ? $videoArr['share_info']['body_map'][0]['desc'] : '',
            isset($videoArr['images'][0]['url']) ? $videoArr['images'][0]['url'] : '',
            isset($videoArr['video_url']) ? $videoArr['video_url'] : '',
            'video'
        );
    }
}