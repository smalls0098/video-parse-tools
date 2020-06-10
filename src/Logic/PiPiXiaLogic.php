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
 * Date：2020/6/10 - 14:13
 **/
class PiPiXiaLogic extends Base
{

    private $itemId;
    private $contents;


    public function setItemId()
    {
        $originalUrl = $this->redirects($this->url, [], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);

        preg_match('/item\/([0-9]+)\?/i', $originalUrl, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("获取不到item_id信息");
        }
        $this->itemId = $match[1];
    }

    public function setContents()
    {
        $newGetContentsUrl = 'https://h5.pipix.com/bds/webapi/item/detail/';

        $contents = $this->get($newGetContentsUrl, [
            'item_id' => $this->itemId,
        ], [
            'Referer' => $newGetContentsUrl,
            'User-Agent' => UserGentType::ANDROID_USER_AGENT
        ]);

        if (empty($contents['data']['item'])) {
            throw new ErrorVideoException("获取不到指定的内容信息");
        }
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents['data']['item'];
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->itemId;
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
        return CommonUtil::getData($this->getContents()['video']['video_fallback']['url_list'][0]['url']);
    }


    public function getVideoImage()
    {
        return CommonUtil::getData($this->getContents()['video']['cover_image']['url_list'][0]['url']);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->getContents()['share']['title']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->getContents()['author']['avatar']['url_list'][0]['url']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->getContents()['author']['name']);
    }


}