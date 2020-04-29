<?php

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 14:32
 **/
class MoMo extends Base implements IVideo
{

    /**
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{MoMo} url cannot be empty");
        }
        if (strpos($url, "immomo.com") == false) {
            throw new ErrorVideoException("{MoMo} the URL must contain one of the domain names izuiyou.com to continue execution");
        }
        preg_match('/new-share-v2\/(.*?).html/i', $url, $itemMatches);

        if ($this->checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("{MoMo} url parsing failed");
        }

        $contents = $this->post('https://m.immomo.com/inc/microvideo/share/profiles', [
            'feedids' => $itemMatches[1]
        ], [
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        if (isset($contents['ec']) && $contents['ec'] != 200) {
            throw new ErrorVideoException("{MoMo} contents parsing failed");
        }

        return $this->returnData(
            $url,
            isset($contents['data']['list'][0]['user']['name']) ? $contents['data']['list'][0]['user']['name'] : '',
            isset($contents['data']['list'][0]['user']['img']) ? $contents['data']['list'][0]['user']['img'] : '',
            isset($contents['data']['list'][0]['video']['decorator_texts']) ? $contents['data']['list'][0]['video']['decorator_texts'] : '',
            isset($contents['data']['list'][0]['video']['cover']['l']) ? $contents['data']['list'][0]['video']['cover']['l'] : '',
            isset($contents['data']['list'][0]['video']['video_url']) ? $contents['data']['list'][0]['video']['video_url'] : '',
            'video'
        );
    }
}