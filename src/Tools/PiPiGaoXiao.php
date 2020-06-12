<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\PiPiGaoXiaoLogic;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 14:32
 **/
class PiPiGaoXiao extends Base implements IVideo
{

    /**
     * 更新时间：2020/6/10
     * @param string $url
     * @return array
     */
    public function start(string $url): array
    {
        $this->logic = new PiPiGaoXiaoLogic($url, $this->urlValidator->get('pipigaoxiao'), $this->config);
        $this->logic->checkUrlHasTrue();
        $this->logic->setPostId();
        $this->logic->setContents();
        return $this->exportData();
    }

}