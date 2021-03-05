<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\NewWeiBoLogic;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/13 - 21:04
 **/
class WeiBo extends Base implements IVideo
{

    private $quality;

    public function setQuality($quality)
    {
        $this->quality = $quality;
        return $this;
    }

    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * 更新时间：2020/7/31
     * @param string $url
     * @return array
     */
    public function start(string $url): array
    {
        $this->make();
        $this->logic->setOriginalUrl($url);
        $this->logic->checkUrlHasTrue();
        $this->logic->setFid();
        $this->logic->setContents();
        return $this->exportData();
    }

}