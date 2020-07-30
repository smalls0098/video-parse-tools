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
 * Date：2020/6/10 - 13:05
 **/
class DouYinLogic extends Base
{

    private $contents;
    private $itemId;

    public function setItemIds()
    {
        if (strpos($this->url, '/share/video')) {
            $url = $this->url;
        } else {
            $url = $this->redirects($this->url, [], [
                'User-Agent' => UserGentType::ANDROID_USER_AGENT,
            ]);
        }
        preg_match('/video\/([0-9]+)\//i', $url, $matches);
        if (CommonUtil::checkEmptyMatch($matches)) {
            throw new ErrorVideoException("item_id获取不到");
        }
        $this->itemId = $matches[1];
    }

    public function setContents()
    {
        $contents = $this->get('https://www.iesdouyin.com/web/api/v2/aweme/iteminfo', [
            'item_ids' => $this->itemId,
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
            'Referer'    => "https://www.iesdouyin.com",
            'Host'       => "www.iesdouyin.com",
        ]);
        if ((isset($contents['status_code']) && $contents['status_code'] != 0) || empty($contents['item_list'][0]['video']['play_addr']['uri'])) {
            throw new ErrorVideoException("parsing failed");
        }
        if (empty($contents['item_list'][0])) {
            throw new ErrorVideoException("不存在item_list无法获取视频信息");
        }
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
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
        if (empty($this->contents['item_list'][0]['video']['play_addr']['uri'])) {
            return '';
        }
        return $this->redirects('https://aweme.snssdk.com/aweme/v1/play/', [
            'video_id' => $this->contents['item_list'][0]['video']['play_addr']['uri'],
            'ratio'    => '720',
            'line'     => '0',
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
    }

    public function getVideoImage()
    {
        return CommonUtil::getData($this->contents['item_list'][0]['video']['cover']['url_list'][0]);
    }

    public function getVideoDesc()
    {
        return CommonUtil::getData($this->contents['item_list'][0]['desc']);
    }

    public function getUsername()
    {
        return CommonUtil::getData($this->contents['item_list'][0]['author']['nickname']);
    }

    public function getUserPic()
    {
        return CommonUtil::getData($this->contents['item_list'][0]['author']['avatar_larger']['url_list'][0]);
    }

}