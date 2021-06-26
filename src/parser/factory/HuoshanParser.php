<?php


namespace smalls\videoParseTools\parser\factory;

use smalls\videoParseTools\enums\UserAgentType;
use smalls\videoParseTools\exception\InvalidParseException;
use smalls\videoParseTools\parser\AbstractParser;
use smalls\videoParseTools\utils\CommonUtil;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
class HuoshanParser extends AbstractParser
{

    private $itemId = "";

    private $contents = [];

    public function handle()
    {
        $this->parseItemIds();
        $this->parseContents();
        $videoUrl = $this->contents['data']['item_info']['url'] ?? '';
        $parseUrl = parse_url($videoUrl);
        if (empty($parseUrl['query'])) {
            throw new InvalidParseException("视频地址不正确");
        }
        parse_str($parseUrl['query'], $parseArr);
        $parseArr['watermark'] = 0;


        $videoUrl = $this->redirects('https://api.huoshan.com/hotsoon/item/video/_source/', $parseArr, [
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT,
        ]);
        if (!$videoUrl) {
            throw new InvalidParseException("视频地址不正确");
        }
        $this->videoUrl = $videoUrl;
        $this->videoCover = isset($this->contents['data']['item_info']['cover']) ?? "";
    }

    private function parseItemIds()
    {
        $originalUrl = $this->redirects($this->originalUrl, [], [
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT,
        ]);
        var_dump($this->originalUrl);
        preg_match('/item_id=([0-9]+)&tag/i', $originalUrl, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new InvalidParseException("item_id获取不到参数");
        }
        $this->itemId = $match[1];
    }

    private function parseContents()
    {
        $contents = $this->get('https://share.huoshan.com/api/item/info', [
            'item_id' => $this->itemId
        ], [
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT,
        ]);

        if ((isset($contents['status_code']) && $contents['status_code'] != 0) || (isset($contents['data']) && $contents['data'] == null)) {
            throw new InvalidParseException("获取不到指定的内容信息");
        }
        $this->contents = $contents;
    }
}