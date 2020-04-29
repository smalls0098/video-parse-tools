<?php

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 21:11
 **/
class QuanMingGaoXiao extends Base implements IVideo
{

    /**
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{QuanMingGaoXiao} url cannot be empty");
        }

        if (strpos($url, "longxia.music.xiaomi.com") == false) {
            throw new ErrorVideoException("{QuanMingGaoXiao} the URL must contain one of the domain names longxia.music.xiaomi.com to continue execution");
        }

        preg_match('/video\/([0-9]+)\?/i', $url, $itemMatches);
        if ($this->checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("{QuanMingGaoXiao} itemMatches parsing failed");
        }
        $contents = $this->get('https://longxia.music.xiaomi.com/api/share', [
            'contentType' => 'video',
            'contentId' => $itemMatches[1],
        ], [
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        if(isset($contents['code']) && $contents['code'] != 200){
            throw new ErrorVideoException("{QuanMingGaoXiao} contents code not 200 parsing failed");
        }

        return $this->returnData(
            $url,
            isset($contents['data']['videoInfo']['author']['authorName']) ? $contents['data']['videoInfo']['author']['authorName'] : '',
            isset($contents['data']['videoInfo']['author']['authorAvatarUrl']) ? $contents['data']['videoInfo']['author']['authorAvatarUrl'] : '',
            isset($contents['data']['videoInfo']['videoInfo']['desc']) ? $contents['data']['videoInfo']['videoInfo']['desc'] : '',
            isset($contents['data']['videoInfo']['videoInfo']['coverUrl']) ? $contents['data']['videoInfo']['videoInfo']['coverUrl'] : '',
            isset($contents['data']['videoInfo']['videoInfo']['url']) ? $contents['data']['videoInfo']['videoInfo']['url'] : '',
            'video'
        );

    }
}