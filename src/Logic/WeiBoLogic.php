<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Logic;

use Smalls\VideoTools\Enumerates\UserGentType;
use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Utils\CommonUtil;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/13 - 21:05
 **/
class WeiBoLogic extends Base
{
    private $contents;
    private $fid;
    private $isVideoLink = false;

    public function setFid()
    {
        // 传进来的就是视频链接
        if (strpos($this->url, 'f.video.weibocdn.com') !== false) {
            $this->isVideoLink = true;
            return ;
        }
        preg_match('/\\d+:\\d+$/', $this->url, $matches);
        if (empty($matches[0])) {
            throw new ErrorVideoException("获取不到 fid");
        }
        $this->fid = $matches[0];
    }

    public function setContents()
    {
        if ($this->isVideoLink) {
            $this->contents['urls'] = [
                "360" => $this->url,
                "480" => $this->url,
                "720" => $this->url,
            ];
            return ;
        }

        $url = 'https://weibo.com/tv/api/component?page=' . urlencode('/tv/show/' . $this->fid);
        $contents = $this->post($url, [
            'data' => '{"Component_Play_Playinfo":{"oid":"'.$this->fid.'"}}'
        ], $this->buildHeaders());

        if (!empty($contents) && !empty($contents['code']) && (int)$contents['code'] === 100000) {
            $this->contents =  !empty($contents['data']['Component_Play_Playinfo']) ? $contents['data']['Component_Play_Playinfo'] : [];

            // 视频质量key替换
            $urls = [];
            foreach ($this->contents['urls'] ?? [] as $k => $v) {
                $key = preg_replace("/\D/i", "", $k);
                $urls[$key] = $v;
            }
            ksort($urls);

            $this->contents['urls'] = $urls;
        }
    }

    private function buildHeaders() {
        return [
            'authority' => 'weibo.com',
            'sec-ch-ua' => '"Google Chrome";v="89", "Chromium";v="89", ";Not A Brand";v="99"',
            'accept' => 'application/json, text/plain, */*',
            'page-referer' => '/tv/show/' . $this->fid,
            'x-xsrf-token' => 'KIedGOc3phEPvpmNfiVk8aMv',
            'sec-ch-ua-mobile' => '?0',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.72 Safari/537.36',
            'content-type' => 'application/x-www-form-urlencoded',
            'origin'  => 'https://weibo.com',
            'sec-fetch-site' => 'same-origin',
            'sec-fetch-mode' => 'cors',
            'sec-fetch-dest' => 'empty',
            'referer' => "https://weibo.com/tv/show/{$this->fid}?from=old_pc_videoshow",
            'accept-language'  => 'zh-CN,zh;q=0.9,en;q=0.8',
            'cookie' => 'UOR=www.baidu.com,app.weibo.com,www.baidu.com; SINAGLOBAL=6175420987754.9.1599925795992; YF-V-WEIBO-G0=b09171a17b2b5a470c42e2f713edace0; SUB=_2AkMXHHWAf8NxqwJRmP0cyWvnb4pxyQDEieKhQIRbJRMxHRl-yT9kqnwstRB6PJxbb6X8M9pRezjdzF64gJ4FpdLwCgHQ; SUBP=0033WrSXqPxfM72-Ws9jqgMF55529P9D9WF8lDgDzml.9CGuK.knKOEU; _s_tentry=passport.weibo.com; Apache=8500388318548.387.1614871224981; ULV=1614871225208:2:1:1:8500388318548.387.1614871224981:1599925796011; XSRF-TOKEN=KIedGOc3phEPvpmNfiVk8aMv; login_sid_t=d7fd538af1eed8b958bfd0bbe04525d1; cross_origin_proto=SSL; wb_view_log=1920*10801',
        ];
    }


    private function getContents()
    {
        return $this->contents;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl()
    {
        $urls = $this->contents['urls'] ?? [];
        $quality = $this->toolsObj->getQuality();
        if (empty($urls)) {
            return "";
        }

        if (empty($quality)) {
           $url = end($urls);
        } else {
            $url = empty($quality) ? end($urls) : ($urls[$quality] ?? end($urls));
        }

        if (!empty($url)) {
            return "https:{$url}";
        }

        return "";
    }

    public function getVideoImage()
    {
        return !empty($this->contents['cover_image']) ? 'https:' .$this->contents['cover_image'] : '';
    }

    public function getVideoDesc()
    {
        return $this->contents['text'] ?? '';
    }

    public function getUsername()
    {
        return $this->contents['nickname'] ?? $this->contents['author'] ?? '';
    }

    public function getUserPic()
    {
        return !empty($this->contents['avatar']) ? 'https:' . $this->contents['avatar'] : '';
    }

}