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
 * Date：2020/6/10 - 18:22
 **/
class PiPiGaoXiaoLogic extends Base
{

    private $postId;
    private $contents;


    public function setPostId()
    {
        preg_match('/pp\/post\/([0-9]+)/i', $this->url, $match);
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("获取不到post_id信息");
        }
        $this->postId = $match[1];
    }

    public function setContents()
    {
        $newGetContentsUrl = 'http://share.ippzone.com/ppapi/share/fetch_content';
        $contents = $this->post($newGetContentsUrl, [
            'pid' => $this->postId,
            'type' => 'post',
            'mid' => '',
        ], [
            'Referer' => $newGetContentsUrl,
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        if ((isset($contents['ret']) && $contents['ret'] != 1) || (isset($contents['data']['post']['imgs'][0]['id']) && !$contents['data']['post']['imgs'][0]['id'])) {
            throw new ErrorVideoException("获取不到指定的内容信息");
        }
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->postId;
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
    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl()
    {
        $id = isset($this->contents['data']['post']['imgs'][0]['id']) ? $this->contents['data']['post']['imgs'][0]['id'] : '';
        if ($id) {
            return isset($this->contents['data']['post']['videos'][$id]['url']) ? $this->contents['data']['post']['videos'][$id]['url'] : '';
        }
        return '';
    }


    public function getVideoImage()
    {
        $id = isset($this->contents['data']['post']['imgs'][0]['id']) ? $this->contents['data']['post']['imgs'][0]['id'] : '';
        if ($id) {
            return "https://file.ippzone.com/img/view/id/{$id}";
        }
        return '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['data']['post']['content']) ? $this->contents['data']['post']['content'] : '';
    }

    public function getUserPic()
    {
        return '';
    }

    public function getUsername()
    {
        return '';
    }


}