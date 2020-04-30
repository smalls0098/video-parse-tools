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

class LiVideo extends Base implements IVideo
{


    public function __construct($params)
    {
    }

    /**
     * 更新时间：2020/4/30
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{LiVideo} url cannot be empty");
        }

        if (strpos($url, "www.pearvideo.com") == false) {
            throw new ErrorVideoException("{LiVideo} the URL must contain one of the domain names www.pearvideo.com to continue execution");
        }

        $contents = $this->get($url, [], [
            'User-Agent' => self::WIN_USER_AGENT,
        ]);

        preg_match('/srcUrl="(.*?)",/i', $contents, $videoMatches);

        if ($this->checkEmptyMatch($videoMatches)) {
            throw new ErrorVideoException("{LiVideo} parsing failed");
        }

        return $this->returnData(
            $url,
            '',
            '',
            '',
            '',
            $videoMatches[1],
            'video'
        );
    }


}