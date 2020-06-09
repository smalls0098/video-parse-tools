<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\ShuaBaoLogic;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 14:32
 **/
class ShuaBao extends Base implements IVideo
{

    /**
     * 更新时间：2020/6/9
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        $this->logic = new ShuaBaoLogic($url);
        $this->logic->checkUrlHasTrue();
        $this->logic->setShowId();
        $this->logic->setContents();
        return $this->exportData();
    }
}