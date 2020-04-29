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
class ShuaBao extends Base implements IVideo
{

    /**
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{ShuaBao} url cannot be empty");
        }
        if (strpos($url, "shua8cn.com/video_share") == false) {
            throw new ErrorVideoException("{ShuaBao} the URL must contain one of the domain names izuiyou.com to continue execution");
        }
        preg_match('/show_id=(.*?)&/i', $url, $itemMatches);

        if ($this->checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("{ShuaBao} url parsing failed");
        }

        $contents = $this->get('http://h5.shua8cn.com/api/video/detail', [
            'show_id' => $itemMatches[1],
            'provider' => 'weixin',
        ], [
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        if (isset($contents['code']) && $contents['code'] != "0") {
            throw new ErrorVideoException("{XiaoKaXiu} contents parsing failed");
        }

        return $this->returnData(
            $url,
            isset($contents['data']['user_info']['nickname']) ? $contents['data']['user_info']['nickname'] : '',
            isset($contents['data']['user_info']['avatar']['720']) ? $contents['data']['user_info']['avatar']['720'] : '',
            isset($contents['data']['description']) ? $contents['data']['description'] : '',
            isset($contents['data']['cover_pic']['720']) ? $contents['data']['cover_pic']['720'] : '',
            isset($contents['data']['video_url']) ? $contents['data']['video_url'] : '',
            'video'
        );
    }
}