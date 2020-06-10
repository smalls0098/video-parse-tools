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
     * 更新时间：2020/6/10
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        $this->logic = new TouTiaoLogic($url, $this->urlValidator->get('xigua'), $this->config);
        $this->logic->checkUrlHasTrue();
        preg_match('/group\/([0-9]+)\/?/i', $url, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("item_id获取失败");
        }
        $this->logic->setContents($match[1]);
        return $this->exportData();
    }

}