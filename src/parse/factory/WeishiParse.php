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
class WeishiParse extends AbstractParse
{

    private $feedId = "";

    private $contents = [];

    public function handle()
    {
        $this->parseItemIds()->parseContents();
        $this->videoUrl = $this->contents['data']['feeds'][0]['video_url'] ?? '';
        $this->videoCover = $this->contents['data']['feeds'][0]['images'][0]['url'] ?? '';
        $this->description = $this->contents['data']['feeds'][0]['share_info']['body_map'][0]['desc'] ?? '';
        $this->userName = $this->contents['data']['feeds'][0]['poster']['nick'] ?? '';
        $this->userHeadImg = $this->contents['data']['feeds'][0]['poster']['avatar'] ?? '';
    }


    private function parseItemIds(): WeishiParse
    {
        preg_match('/feed\/(.*?)\/wsfeed/i', $this->originalUrl, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new InvalidParseException("feed_id参数获取失败");
        }
        $this->feedId = $match[1];
        return $this;
    }

    private function parseContents(): WeishiParse
    {
        $contents = $this->post('https://h5.qzone.qq.com/webapp/json/weishi/WSH5GetPlayPage?t=0.4185745904612037&g_tk=', [
            'feedid' => $this->feedId,
        ], [
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT
        ]);
        $this->contents = $contents;
        return $this;
    }
}