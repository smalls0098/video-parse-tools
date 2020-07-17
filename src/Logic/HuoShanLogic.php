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
 * Date：2020/6/10 - 13:40
 **/
class HuoShanLogic extends Base
{

    private $itemId;

    private $contents;


    public function setItemId()
    {
        $originalUrl = $this->redirects($this->url, [], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        preg_match('/item_id=([0-9]+)&tag/i', $originalUrl, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("item_id获取不到参数");
        }
        $this->itemId = $match[1];
        return $this->itemId;
    }

    public function setContents()
    {
        $contents = $this->get('https://share.huoshan.com/api/item/info', [
            'item_id' => $this->itemId
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);

        if ((isset($contents['status_code']) && $contents['status_code'] != 0) || (isset($contents['data']) && $contents['data'] == null)) {
            throw new ErrorVideoException("获取不到指定的内容信息");
        }
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl()
    {
        $videoUrl = isset($this->contents['data']['item_info']['url']) ? $this->contents['data']['item_info']['url'] : '';
        $parseUrl = parse_url($videoUrl);
        if (empty($parseUrl['query'])) {
            return '';
        }
        parse_str($parseUrl['query'], $parseArr);
        $parseArr['watermark'] = 0;

        $videoUrl = $this->redirects('https://api.huoshan.com/hotsoon/item/video/_source/', $parseArr, [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        if (!$videoUrl) {
            return '';
        }
        return $videoUrl;
    }

    public function getVideoImage()
    {
        return isset($this->contents['data']['item_info']['cover']) ? $this->contents['data']['item_info']['cover'] : '';
    }

    public function getVideoDesc()
    {
        return '';
    }

    public function getUsername()
    {
        return '';
    }

    public function getUserPic()
    {
        return '';
    }


}