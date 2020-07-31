<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Enumerates\BiliQualityType;
use Smalls\VideoTools\Interfaces\IVideo;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/8 - 22:13
 **/
class Bili extends Base implements IVideo
{

    private $url = '';
    /**
     * @var string
     */
    private $cookie = '';
    private $quality = BiliQualityType::LEVEL_2;

    /**
     * 更新时间：2020/7/31
     * 暂时还没修复完整
     * @param string $url
     * @return array
     */
    public function start(string $url): array
    {
        $this->url     = $url;
        $this->cookie  = '';
        $this->quality = BiliQualityType::LEVEL_2;
        return $this->execution();
    }

    /**
     * 更新时间：2020/6/10
     * @return array
     */
    public function execution(): array
    {
        $this->make();
        $this->logic->setOriginalUrl($this->url);
        $this->logic->init($this->getCookie(), $this->getQuality());
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
    public function setCookie(string $cookie = ''): self
    {
        $this->cookie = $cookie == '' ? $cookie : '';
        return $this;
    }

    /**
     * @return string
     */
    public function getCookie(): string
    {
        return $this->cookie;
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
     * @return mixed
     */
    public function getQuality()
    {
        return $this->quality;
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