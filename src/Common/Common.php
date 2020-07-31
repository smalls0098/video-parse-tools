<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Common;

/**
 * 努力努力再努力！！！！！
 * Author：smalls
 * Github：https://github.com/smalls0098
 * Email：smalls0098@gmail.com
 * Date：2020/7/30 - 17:10
 **/
abstract class Common
{


    /**
     * 代理信息
     * @var string
     */
    private $proxy = '';

    /**
     * 是否验证url，否的话则自己需要验证
     * @var bool
     */
    private $isCheckUrl = true;


    /**
     * 设置代理 | 传参即是代表需要开启代理模式
     * 这边只能接受字符串，数组的话没办法使用
     * @param string $proxy 主机:端口 例如[47.112.221.156:3128]
     * @return $this
     * @author smalls
     * @email smalls0098@gmail.com
     */
    public function setProxy(string $proxy): self
    {
        $this->proxy = $proxy;
        return $this;
    }

    public function getProxy(): string
    {
        return $this->proxy;
    }

    public function getIsCheckUrl(): bool
    {
        return $this->isCheckUrl;
    }

    /**
     * 是否开启url的验证，如果外层验证过了，这边可以不用验证，传递false就可以
     * @param bool $isCheckUrl
     * @return $this
     * @author smalls
     * @email smalls0098@gmail.com
     */
    public function setIsCheckUrl(bool $isCheckUrl): self
    {
        $this->isCheckUrl = $isCheckUrl;
        return $this;
    }
}