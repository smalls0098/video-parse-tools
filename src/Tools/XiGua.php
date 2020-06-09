<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Logic\TouTiaoLogic;
use Smalls\VideoTools\Utils\CommonUtil;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 14:32
 **/
class XiGua extends Base implements IVideo
{

    /**
     * 更新时间：2020/6/9
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("url cannot be empty");
        }
        if (strpos($url, "xigua.com") == false) {
            throw new ErrorVideoException("there was a problem with url verification");
        }
        preg_match('/group\/([0-9]+)\/?/i', $url, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("url parsing failed");
        }
        $this->logic = new TouTiaoLogic($url);
        $this->logic->setContents($match[1]);
        return $this->exportData();
    }

}