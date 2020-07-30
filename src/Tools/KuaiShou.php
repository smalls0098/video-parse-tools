<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\KuaiShouLogic;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 0:46
 **/
class KuaiShou extends Base implements IVideo
{

    /**
     * 更新时间：2020/7/17
     * @param string $url
     * @return array
     */
    public function start(string $url): array
    {
        $this->logic = new KuaiShouLogic($url, $this->urlValidator->get('kuaishou'), $this->config);
        $this->logic->checkUrlHasTrue();
        $this->logic->setContents();
        return $this->exportData();
    }

}