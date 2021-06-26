<?php


namespace smalls\videoParseTools\parser;

use smalls\videoParseTools\common\HttpRequest;
use smalls\videoParseTools\common\Log;
use smalls\videoParseTools\interfaces\IParser;
use smalls\videoParseTools\parser\model\ParseResponse;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
abstract class AbstractParser implements IParser
{

    use HttpRequest;

    use Log;

    protected $originalUrl = "";

    protected $userName = "";

    protected $userHeadImg = "";

    protected $description = "";

    protected $videoCover = "";

    protected $videoUrl = "";


    public function sendResponse(): ParseResponse
    {
        return new ParseResponse($this->originalUrl, $this->userName, $this->userHeadImg, $this->description, $this->videoCover, $this->videoUrl);
    }

    public function execute(string $url): ParseResponse
    {
        $this->originalUrl = $url;
        $this->handle();
        return self::sendResponse();
    }


    public abstract function handle();

    /**
     * @return string
     */
    public function getOriginalUrl(): string
    {
        return $this->originalUrl;
    }

    /**
     * @param string $originalUrl
     * @return AbstractParser
     */
    public function setOriginalUrl(string $originalUrl): AbstractParser
    {
        $this->originalUrl = $originalUrl;
        return $this;
    }


}