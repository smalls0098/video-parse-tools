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

    private $pid;
    private $mid;
    private $contents;

    /**
     * @throws ErrorVideoException
     */
    public function setPidAndMid()
    {
        $parseUrl = parse_url($this->url);
        $query = $parseUrl['query'] ?? '';
        if (empty($query)) {
            throw new ErrorVideoException("皮皮搞笑视频 url 不完整");
        }

        parse_str($query, $queryParam);
        $this->pid = $queryParam['pid'] ?? '';
        $this->mid = $queryParam['mid'] ?? '';

        if (empty($this->pid) || empty($this->mid)) {
            throw new ErrorVideoException("pid 或者 mid 为空");
        }
    }

    /**
     * @throws ErrorVideoException
     */
    public function setContents()
    {
        $newGetContentsUrl = 'https://h5.pipigx.com/ppapi/share/fetch_content';
        $contents = $this->post($newGetContentsUrl, [
            'pid' => (int)$this->getPid(),
            'type' => 'post',
            'mid' => (int)$this->getMid(),
        ], [
            'Referer' => $this->url,
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
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @return mixed
     */
    public function getMid()
    {
        return $this->mid;
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