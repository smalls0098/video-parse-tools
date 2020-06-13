<?php

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\NewWeiBoLogic;
use Smalls\VideoTools\Logic\WeiBoLogic;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/13 - 21:04
 **/
class WeiBo extends Base implements IVideo
{


    public function start(string $url): array
    {
        $this->logic = new WeiBoLogic($url, $this->urlValidator->get('weibo'), $this->config);
        $this->logic->checkUrlHasTrue();
        $this->logic->setStatusId();
        $this->logic->setContents();
        return $this->exportData();
    }

    public function newVideoStart(string $url): array
    {
        $this->logic = new NewWeiBoLogic($url, $this->urlValidator->get('newweibo'), $this->config);
        $this->logic->checkUrlHasTrue();
        $this->logic->setFid();
        $this->logic->setMid();
        $this->logic->setContents();
        return $this->exportData();
    }

}