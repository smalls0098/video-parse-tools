<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Enumerates\BiliQualityType;
use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\BiliLogic;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/8 - 22:13
 **/
class Bili extends Base implements IVideo
{

    private $cookie = '';
    private $quality = BiliQualityType::LEVEL_5;
    private $url;

    /**
     * 更新时间：2020/6/10
     * B.站有一个问题，就是解析出来的链接需要设置referer
     * 如果把IP定位到国外就不会有事
     * 我建议多加一个节点到香港之类的，专门用于指定的一些解析。
     * 也可以使用代理，需要自己写一下，我后续如果有弄可以加进去
     * @param string $url
     * @return array
     */
    public function start(string $url): array
    {
        $this->url = $url;
        return $this->execution();
    }

    /**
     * 更新时间：2020/6/10
     * @return array
     */
    public function execution(): array
    {
        $this->logic = new BiliLogic($this->url, $this->cookie, $this->quality, $this->urlValidator->get('bili'), $this->config);
        $this->logic->checkUrlHasTrue();
        $this->logic->setAidAndCid();
        $this->logic->setContents();
        return $this->exportData();
    }

    /**
     * 设置cookie
     * @param string $cookie
     * @return $this
     */
    public function setCookie(string $cookie = '')
    {
        $this->cookie = $cookie == '' ? $cookie : '';
        return $this;
    }

    /**
     * 清晰度
     * @param mixed $quality
     * @return Bili
     */
    public function setQuality(int $quality = BiliQualityType::LEVEL_5)
    {
        $this->quality = $quality;
        return $this;
    }

    /**
     * 设置URL
     * @param mixed $url
     * @return Bili
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

}