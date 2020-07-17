<?php

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\QQVideoLogic;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/7/17 - 16:11
 **/
class QQVideo extends Base implements IVideo
{


    public function start(string $url): array
    {
        $this->logic = new QQVideoLogic($url, $this->urlValidator->get('qqvideo'), $this->config);
        $this->logic->checkUrlHasTrue();
        $this->logic->setVid();
        $this->logic->setContents();
        return $this->exportData();
    }

}