<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Enumerates\UserGentType;
use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Utils\CommonUtil;
use Smalls\VideoTools\Utils\MeiPaiUtil;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/10 - 14:51
 **/
class MeiPaiLogic extends Base
{

    private $title;
    private $userName;
    private $userPic;
    private $videoPic;
    private $videoBase64Url;
    private $contents;


    public function setContents()
    {
        $contents       = $this->get($this->url, [], [
            'User-Agent' => UserGentType::WIN_USER_AGENT,
        ]);
        $this->contents = $contents;
    }

    public function setVideoRelatedInfo()
    {
        $contents = $this->contents;
        preg_match('/data-video="(.*?)"/i', $contents, $videoMatches);

        preg_match('/img src="(.*?)" width="74" height="74" class="avatar pa detail-avatar" alt="(.*?)"/i', $contents, $userInfoMatches);
        preg_match('/<img src="(.*?)"/i', $contents, $videoImageMatches);
        preg_match('/<title>(.*?)<\/title>/i', $contents, $titleMatches);
        if (CommonUtil::checkEmptyMatch($videoMatches) || CommonUtil::checkEmptyMatch($userInfoMatches) || CommonUtil::checkEmptyMatch($videoImageMatches) || CommonUtil::checkEmptyMatch($titleMatches)) {
            throw new ErrorVideoException("获取不到视频信息和用户信息");
        }
        $this->title          = $titleMatches[1];
        $this->userName       = $userInfoMatches[1];
        $this->userPic        = $userInfoMatches[2];
        $this->videoPic       = $videoImageMatches[1];
        $this->videoBase64Url = $videoMatches[1];
    }


    public function getVideoUrl()
    {
        $hex      = MeiPaiUtil::getHex($this->videoBase64Url);
        $arr      = MeiPaiUtil::getDec($hex[0]);
        $d        = MeiPaiUtil::subStr($arr[0], $hex[1]);
        $videoUrl = base64_decode(MeiPaiUtil::subStr(MeiPaiUtil::getPos($d, $arr[1]), $d));
        return $videoUrl;
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
    public function getVideoDesc()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getUserPic()
    {
        return $this->userPic;
    }

    /**
     * @return mixed
     */
    public function getVideoImage()
    {
        return $this->videoPic;
    }

    /**
     * @return mixed
     */
    public function getVideoBase64Url()
    {
        return $this->videoBase64Url;
    }


}