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
class DouyinParser extends AbstractParser
{


    private $itemId = "";

    private $contents = [];

    public function handle()
    {
        $this->parseItemIds();
        $this->parseContents();
        if (empty($this->contents['item_list'][0]['video']['play_addr']['uri'])) {
            throw new InvalidParseException("item_id获取不到");
        }
        $this->videoUrl = $this->redirects('https://aweme.snssdk.com/aweme/v1/play/', [
            'video_id' => $this->contents['item_list'][0]['video']['play_addr']['uri'],
            'ratio' => '720',
            'line' => '0',
        ], [
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT,
        ]);
        $this->videoCover = CommonUtil::getData($this->contents['item_list'][0]['video']['cover']['url_list'][0]);
        $this->description = CommonUtil::getData($this->contents['item_list'][0]['desc']);
        $this->userName = CommonUtil::getData($this->contents['item_list'][0]['author']['nickname']);
        $this->userHeadImg = CommonUtil::getData($this->contents['item_list'][0]['author']['avatar_larger']['url_list'][0]);
    }

    private function parseItemIds()
    {
        if (strpos($this->originalUrl, '/share/video')) {
            $url = $this->originalUrl;
        } else {
            $url = $this->redirects($this->originalUrl, [], [
                'User-Agent' => UserAgentType::ANDROID_USER_AGENT,
            ]);
        }
        preg_match('/video\/([0-9]+)\//i', $url, $matches);
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new InvalidParseException("item_id获取不到");
        }
        $this->itemId = $matches[1];
    }

    private function parseContents()
    {
        $contents = $this->get('https://www.iesdouyin.com/web/api/v2/aweme/iteminfo', [
            'item_ids' => $this->itemId,
        ], [
//            'User-Agent' => UserAgentType::ANDROID_USER_AGENT, // 这边使用安卓的会出现问题
            'Referer' => "https://www.iesdouyin.com",
            'Host' => "www.iesdouyin.com",
        ]);
        if ((isset($contents['status_code']) && $contents['status_code'] != 0) || empty($contents['item_list'][0]['video']['play_addr']['uri'])) {
            throw new InvalidParseException("parsing failed");
        }
        if (empty($contents['item_list'][0])) {
            throw new InvalidParseException("不存在item_list无法获取视频信息");
        }
        $this->contents = $contents;
    }
}