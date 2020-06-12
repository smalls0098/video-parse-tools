<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;
/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 21:57
 **/

use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\LiVideoLogic;

class LiVideo extends Base implements IVideo
{

    /**
     * 更新时间：2020/6/10
     * @param string $url
     * @return array
     */
    public function start(string $url): array
    {
        $this->logic = new LiVideoLogic($url, $this->urlValidator->get('livideo'), $this->config);
        $this->logic->checkUrlHasTrue();
        $this->logic->setContents();
        $this->logic->setVideoUrl();
        return $this->exportData();
    }
}