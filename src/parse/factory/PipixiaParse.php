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
class PipixiaParse extends AbstractParse
{

    public function handle()
    {
        $itemId = $this->getItemId();
        $contents = $this->getContents($itemId);
        $this->videoUrl = $this->redirects('http://hotsoon.snssdk.com/hotsoon/item/video/_playback/', [
            'video_id' => $this->getVideoId($itemId),
        ], [
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT
        ]);
        $this->videoCover = $contents['data']['item']['video']['cover_image']['url_list'][0]['url'] ?? '';
        $this->description = $contents['data']['item']['share']['title'] ?? '';
        $this->userHeadImg = $contents['data']['item']['author']['avatar']['url_list'][0]['url'] ?? '';
        $this->userName = $contents['data']['item']['author']['name'] ?? '';
    }

    public function getItemId(): string
    {
        $originalUrl = $this->redirects($this->originalUrl, [], [
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT,
        ]);
        preg_match('/item\/([0-9]+)\?/i', $originalUrl, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new InvalidParseException("获取不到item_id信息");
        }
        return $match[1];
    }

    public function getContents(string $itemId): array
    {
        $newGetContentsUrl = 'https://h5.pipix.com/bds/webapi/item/detail/';

        $contents = $this->get($newGetContentsUrl, [
            'item_id' => $itemId,
        ], [
            'Referer' => $newGetContentsUrl,
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT
        ]);

        if (empty($contents['data']['item'])) {
            throw new InvalidParseException("获取不到指定的内容信息");
        }
        return $contents;
    }

    private function getVideoId(string $itemId)
    {
        $getContentUrl = 'https://m.365yg.com/i' . $itemId . '/info/';

        $contents = $this->get($getContentUrl, ['i' => $itemId], [
            'Referer' => $getContentUrl,
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT
        ]);
        $decode = json_decode($contents['data']['content'], true);
        if (empty($decode['video']['vid'])) {
            throw new InvalidParseException("获取不到指定的内容信息");
        }
        return $decode['video']['vid'];
    }

}