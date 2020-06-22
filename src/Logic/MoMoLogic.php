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
class MoMoLogic extends Base
{

    private $contents;
    private $feedId;


    public function setFeedId()
    {
        preg_match('/new-share-v2\/(.*?).html/i', $this->url, $itemMatches);
        if (CommonUtil::checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("获取不到feed_id信息");
        }
        $this->feedId = $itemMatches[1];
    }

    public function setContents()
    {
        $contents = $this->post('https://m.immomo.com/inc/microvideo/share/profiles', [
            'feedids' => $this->feedId
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);

        if (isset($contents['ec']) && $contents['ec'] != 200) {
            throw new ErrorVideoException("获取不到指定的内容信息");
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
    public function getUrl()
    {
        return $this->url;
    }

    public function getVideoUrl()
    {
        return isset($this->contents['data']['list'][0]['video']['video_url']) ? $this->contents['data']['list'][0]['video']['video_url'] : '';
    }


    public function getVideoImage()
    {
        return isset($this->contents['data']['list'][0]['video']['cover']['l']) ? $this->contents['data']['list'][0]['video']['cover']['l'] : '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['data']['list'][0]['video']['decorator_texts']) ? $this->contents['data']['list'][0]['video']['decorator_texts'] : '';
    }

    public function getUserPic()
    {
        return isset($this->contents['data']['list'][0]['user']['img']) ? $this->contents['data']['list'][0]['user']['img'] : '';
    }

    public function getUsername()
    {
        return isset($this->contents['data']['list'][0]['user']['name']) ? $this->contents['data']['list'][0]['user']['name'] : '';
    }


}