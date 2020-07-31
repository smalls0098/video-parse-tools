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

    /**
     * 请求的url地址
     * @var string
     */
    protected $url;
    /**
     * 校验的url列表
     * @var array
     */
    protected $urlList;

    /**
     * 是否开启检查验证列表
     * @var bool
     */
    private $isCheckUrl;

    /**
     * 代理类型 默认为false
     * @var bool
     */
    protected $isProxy = false;

    /**
     * 代理IP和端口号，需要用:隔开
     * @var mixed|string
     */
    protected $proxyIpPort = "";

    protected $logDir = __DIR__ . "/../../log/";


    public function __construct($tools)
    {
        //获取类名
        $className = str_replace(__NAMESPACE__, "", get_class($this));
        $className = substr($className, 1, strlen($className) - 6);
        $className = strtolower($className);
        //初始化数据
        $this->urlList     = $tools->getUrlValidator()->get($className, []);
        $this->isCheckUrl  = $tools->getIsCheckUrl();
        $this->proxyIpPort = $tools->getProxy();
        if ($this->proxyIpPort) {
            $this->isProxy = true;
        }
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

    /**
     * 测试的时候写入日志使用
     * @param string $contents
     * @param string $suffix
     */
    public function WriterTestLog($contents = '', $suffix = 'log')
    {
        file_put_contents($this->logDir . (string)time() . "." . $suffix, $contents);
    }


    public function setOriginalUrl(string $url)
    {
        if (!$url) {
            throw new ErrorVideoException('网址不能为空');
        }
        $this->url = $url;
    }

}