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
 * Date：2020/6/10 - 16:41
 **/
class QuanMingGaoXiaoLogic extends Base
{

    private $contentId;
    private $contents;


    public function setContentId()
    {
        preg_match('/video\/([0-9]+)\?/i', $this->url, $itemMatches);
        if (CommonUtil::checkEmptyMatch($itemMatches)) {
            throw new ErrorVideoException("获取不到content_id信息");
        }
        $this->contentId = $itemMatches[1];
        return $itemMatches[1];
    }

    public function getContents()
    {
        $contents = $this->get('https://longxia.music.xiaomi.com/api/share', [
            'contentType' => 'video',
            'contentId'   => $this->contentId,
        ], [
            'User-Agent' => UserGentType::ANDROID_USER_AGENT,
        ]);

        if (isset($contents['code']) && $contents['code'] != 200) {
            throw new ErrorVideoException("contents code not 200 parsing failed");
        }
        if (empty($contents['data']['videoInfo'])) {
            throw new ErrorVideoException("内容不存在 data -> videoInfo");
        }
        $this->contents = $contents['data']['videoInfo'];
    }

    /**
     * @return mixed
     */
    public function getContentId()
    {
        return $this->contentId;
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
        return isset($this->contents['videoInfo']['url']) ? $this->contents['videoInfo']['url'] : '';
    }

    public function getVideoImage()
    {
        return isset($this->contents['videoInfo']['coverUrl']) ? $this->contents['videoInfo']['coverUrl'] : '';
    }

    public function getVideoDesc()
    {
        return isset($this->contents['videoInfo']['desc']) ? $this->contents['videoInfo']['desc'] : '';
    }

    public function getUsername()
    {
        return isset($this->contents['author']['authorName']) ? $this->contents['author']['authorName'] : '';
    }

    public function getUserPic()
    {
        return isset($this->contents['author']['authorAvatarUrl']) ? $this->contents['author']['authorAvatarUrl'] : '';
    }


}