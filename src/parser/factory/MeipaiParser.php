<?php


namespace smalls\videoParseTools\parser\factory;


use smalls\videoParseTools\enums\UserAgentType;
use smalls\videoParseTools\exception\InvalidParseException;
use smalls\videoParseTools\parser\AbstractParser;
use smalls\videoParseTools\utils\CommonUtil;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
class MeipaiParser extends AbstractParser
{

    public function handle()
    {
        $contents = $this->getContents();
        preg_match('/data-video="(.*?)"/i', $contents, $videoMatches);
        preg_match('/img src="(.*?)" width="74" height="74" class="avatar pa detail-avatar" alt="(.*?)"/i', $contents, $userInfoMatches);
        preg_match('/<img src="(.*?)"/i', $contents, $videoImageMatches);
        preg_match('/<title>(.*?)<\/title>/i', $contents, $titleMatches);
        if (CommonUtil::checkEmptyMatch($videoMatches) ||
            CommonUtil::checkEmptyMatch($userInfoMatches) ||
            CommonUtil::checkEmptyMatch($videoImageMatches) ||
            CommonUtil::checkEmptyMatch($titleMatches)) {
            throw new InvalidParseException("获取不到视频信息和用户信息");
        }
        $title = $titleMatches[1];
        $userName = $userInfoMatches[1];
        $userPic = $userInfoMatches[2];
        $videoPic = $videoImageMatches[1];
        $videoBase64Url = $videoMatches[1];
        $videoUrl = $this->getVideoUrl($videoBase64Url);

        $this->videoCover = $videoPic;
        $this->description = $title;
        $this->userName = $userName;
        $this->userHeadImg = $userPic;
        $this->videoUrl = $videoUrl;
    }

    public function getContents(): string
    {
        return $this->get($this->getOriginalUrl(), [], [
            'User-Agent' => UserAgentType::PC_USER_AGENT,
        ]);
    }

    public function getVideoUrl(string $videoBase64Url)
    {
        $hex = self::getHex($videoBase64Url);
        $arr = self::getDec($hex[0]);
        $d = self::subStr($arr[0], $hex[1]);
        return base64_decode(self::subStr(self::getPos($d, $arr[1]), $d));
    }


    private static function getHex($base64)
    {
        return [
            strrev(substr($base64, 0, 4)),
            substr($base64, 4)
        ];
    }

    private static function getDec($str)
    {
        $a_arr = [];
        $b_arr = [];
        foreach (str_split((string)hexdec($str)) as $id => $v) {
            if ($id >= 2) {
                $b_arr[] = $v;
            } else {
                $a_arr[] = $v;
            }
        }
        return array($a_arr, $b_arr);
    }

    private static function subStr($arr, $hex)
    {
        $k = $arr[0];
        $c = substr($hex, 0, (int)$k);
        $temp = str_replace(substr($hex, (int)$k, (int)$arr[1]), "", substr($hex, (int)$arr[0]));
        return $c . $temp;
    }

    private static function getPos($a, $b)
    {
        $b[0] = (string)(strlen($a) - $b[0] - $b[1]);
        return $b;
    }
}