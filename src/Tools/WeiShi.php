<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;
/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 21:57
 **/

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\WeiShiLogic;

class WeiShi extends Base implements IVideo
{

    /**
     * 更新时间：2020/6/10
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        $this->logic = new WeiShiLogic($url, $this->config->get('weishi'));
        $this->logic->checkUrlHasTrue();
        $this->logic->setFeedId();
        $this->logic->setContents();
        return $this->exportData();
    }
}