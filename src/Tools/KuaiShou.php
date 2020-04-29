<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 0:46
 **/
class KuaiShou extends Base implements IVideo
{

    /**
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{KuaiShou} url cannot be empty");
        }

        if (strpos($url, "ziyang.m.kspkg.com") == false && strpos($url, "kuaishou.com") == false && strpos($url, "gifshow.com") == false && strpos($url, "chenzhongtech.com") == false) {
            throw new ErrorVideoException("{KuaiShou} the URL must contain one of the domain names ziyang.m.kspkg.com or kuaishou.com or gifshow.com or chenzhongtech.com to continue execution");
        }

        $contents = $this->get($url, [], [
            'User-Agent' => self::ANDROID_USER_AGENT,
            'cookie' => 'did=web_00536bb16309421a93a09c3e4998aa04; didv=' . time() . '000; clientid=3; client_key=6589' . rand(1000, 9999),
        ]);

        preg_match('/data-pagedata="(.*?)"/i', $contents, $match);
        if ($this->checkEmptyMatch($match)) {
            throw new ErrorVideoException("{KuaiShou} contents parsing failed");
        }
        $contents = htmlspecialchars_decode($match[1]);
        $data = json_decode($contents, true);

        return $this->returnData(
            $url,
            isset($data['user']['name']) ? $data['user']['name'] : '',
            isset($data['user']['avatar']) ? $data['user']['avatar'] : '',
            isset($data['video']['caption']) ? $data['video']['caption'] : '',
            isset($data['video']['poster']) ? $data['video']['poster'] : '',
            isset($data['video']['srcNoMark']) ? $data['video']['srcNoMark'] : '',
            isset($data['video']['type']) ? $data['video']['type'] : 'video'
        );
    }
}