<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Traits\HttpRequest;
use Smalls\VideoTools\Utils\CommonUtil;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/10 - 11:49
 **/
class Base
{

    use HttpRequest;

    protected $url;
    protected $urlList;

    private $isCheckUrl = true;

    public function __construct($url, $urlList)
    {
        $this->url = $url;
        $this->urlList = $urlList;
    }

    public function checkUrlHasTrue()
    {
        if ($this->isCheckUrl) {
            if (empty($this->url)) {
                throw new ErrorVideoException("URL为空");
            }
            if (empty($this->urlList)) {
                throw new ErrorVideoException("校验URL列表为空");
            }
            if (!CommonUtil::checkArrContainStr($this->urlList, $this->url)) {
                throw new ErrorVideoException("URL校验失败");
            }
        }
    }

}