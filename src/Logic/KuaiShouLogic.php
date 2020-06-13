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
 * Date：2020/6/10 - 13:24
 **/
class KuaiShouLogic extends Base
{

    private $match;
    private $contents;

    /**
     * 多了可能是短时间屏蔽IP
     * @throws ErrorVideoException
     */
    public function setContents()
    {
        $cookie = $this->config->get('kuaishou_cookie', 'did=web_00536bb16309421a93a09c3e4998aa04; didv=1586963699000; clientid=3; client_key=65890b29; kuaishou.live.bfb1s=7206d814e5c089a58c910ed8bf52ace5; Hm_lvt_86a27b7db2c5c0ae37fee4a8a35033ee=1589811139,1591779408,1591880526; Hm_lpvt_86a27b7db2c5c0ae37fee4a8a35033ee=1591880526');
        $contents = $this->get($this->url, [], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
            'cookie' => $cookie,
        ]);
        //file_put_contents($this->logDir . (string)time() . ".html", $contents);
        preg_match('/data-pagedata="(.*?)"/i', $contents, $this->match);
        if (CommonUtil::checkEmptyMatch($this->match)) {
            preg_match('/window.pageData= (.*?)<\/script>/i', $contents, $this->match);
        }
        if (CommonUtil::checkEmptyMatch($this->match)) {
            throw new ErrorVideoException("获取不到指定的内容信息");
        }
    }

    public function formatData()
    {
        $contents = htmlspecialchars_decode($this->match[1]);
        if (!$contents || $contents == NULL) {
            throw new ErrorVideoException("内容为空");
        }
        $this->contents = json_decode($contents, true);
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl()
    {
        return CommonUtil::getData($this->contents['video']['srcNoMark']);
    }

    public function getVideoImage()
    {
        return CommonUtil::getData($this->contents['video']['poster']);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->contents['video']['caption']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->contents['user']['name']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->contents['user']['avatar']);
    }


}