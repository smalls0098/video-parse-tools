<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Utils\CommonUtil;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/10 - 14:00
 **/
class XiGuaLogic extends TouTiaoLogic
{

    public function setItemId()
    {
        preg_match('/group\/([0-9]+)\/?/i', $this->url, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("item_id获取失败");
        }
        $this->itemId = $match[1];
    }
}