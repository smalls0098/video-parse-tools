<?php


namespace smalls\videoParseTools\parse\factory;

use smalls\videoParseTools\enums\UserAgentType;
use smalls\videoParseTools\exception\InvalidParseException;
use smalls\videoParseTools\parse\AbstractParse;
use smalls\videoParseTools\utils\CommonUtil;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
class ToutiaoParse extends AbstractParse
{


    private $itemId = "";

    private $contents = [];

    public function handle()
    {
        $this->parseItemIds();
        $this->parseContents();
        if (empty($this->contents['data']['video_id'])) {
            throw new InvalidParseException("item_id获取不到");
        }
        $this->videoUrl = $this->redirects('http://hotsoon.snssdk.com/hotsoon/item/video/_playback/', [
            'video_id' => $this->contents['data']['video_id'],
        ], [
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT
        ]);
        $this->videoCover = $this->contents['data']['poster_url'] ?? '';
        $this->description = $this->contents['data']['title'] ?? '';
        $this->userName = $this->contents['data']['media_user']['screen_name'] ?? '';
        $this->userHeadImg = $this->contents['data']['media_user']['avatar_url'] ?? '';
    }

    private function parseItemIds()
    {
        if (strpos($this->originalUrl, 'v.ixigua.com')) {
            $url = $this->redirects($this->originalUrl);
        } else {
            $url = $this->originalUrl;
        }
        if (strpos($url, 'group')) {
            preg_match('/group\/([0-9]+)\/?/i', $url, $match);
        } else {
            preg_match('/a([0-9]+)\/?/i', $url, $match);
        }
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new InvalidParseException("获取不到item_id参数信息");
        }
        $this->itemId = $match[1];
    }

    private function parseContents()
    {
        $getContentUrl = 'https://m.365yg.com/i' . $this->itemId . '/info/';

        $contents = $this->get($getContentUrl, ['i' => $this->itemId], [
            'Referer' => $getContentUrl,
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT
        ]);

        if (empty($contents['data']['video_id'])) {
            throw new InvalidParseException("获取不到指定的内容信息");
        }
        $this->contents = $contents;
    }
}