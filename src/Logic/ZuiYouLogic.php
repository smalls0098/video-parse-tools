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
class ZuiYouLogic extends Base
{

    private $pid;
    private $contents;
    private $id;


    public function setPId()
    {
        if (strpos($this->url, 'hybrid/share/post')) {
            preg_match('/hybrid\/share\/post\?pid=([0-9]+)&/i', $this->url, $match);
        } elseif (strpos($this->url, '/detail/')) {
            preg_match('/detail\/([0-9]+)\/?/i', $this->url, $match);
        } else {
            throw new ErrorVideoException("提交的域名不符合格式");
        }
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new ErrorVideoException("获取不到pid参数信息");
        }
        $this->pid = $match[1];
    }

    public function setContents()
    {
        $newGetContentsUrl = 'https://share.izuiyou.com/api/post/detail';
        $contents          = $this->post($newGetContentsUrl, '{"pid":' . $this->pid . '}', [
            'Referer'    => $newGetContentsUrl,
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);
        $this->contents    = $contents;
    }

    public function parseId()
    {
        $contents = $this->contents;
        if ((isset($contents['ret']) && $contents['ret'] != 1) || (isset($contents['data']['post']['imgs'][0]['id']) && $contents['data']['post']['imgs'][0]['id'] == null)) {
            throw new ErrorVideoException("获取不到指定的内容信息");
        }
        $id       = $contents['data']['post']['imgs'][0]['id'];
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents['data']['post'];
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
    public function getId()
    {
        return $this->id;
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
        return isset($this->contents['data']['post']['videos'][$this->id]['url']) ? $this->contents['data']['post']['videos'][$this->id]['url'] : '';
    }


    public function getVideoImage()
    {
        if (empty($this->contents['data']['post']['imgs'][0]['id'])) {
            return '';
        }
        $id = $this->contents['data']['post']['imgs'][0]['id'];
        if ($id) {
            return 'http://tbfile.izuiyou.com/img/frame/id/' . $id;
        }
    }

    public function getVideoDesc()
    {
        return isset($this->contents['data']['post']['content']) ? $this->contents['data']['post']['content'] : '';
    }

    public function getUsername()
    {
        return isset($this->contents['data']['post']['member']['name']) ? $this->contents['data']['post']['member']['name'] : '';
    }

    public function getUserPic()
    {
        return isset($this->contents['data']['post']['member']['avatar_urls']['aspect_low']['urls'][0]) ? $this->contents['data']['post']['member']['avatar_urls']['aspect_low']['urls'][0] : '';
    }


}