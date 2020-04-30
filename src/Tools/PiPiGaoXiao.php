<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 14:32
 **/
class PiPiGaoXiao extends Base implements IVideo
{

    /**
     * 更新时间：2020/4/30
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{PiPiGaoXiao} url cannot be empty");
        }
        if (strpos($url, "ippzone.com") == false) {
            throw new ErrorVideoException("{PiPiGaoXiao} the URL must contain one of the domain names izuiyou.com to continue execution");
        }
        preg_match('/pp\/post\/([0-9]+)/i', $url, $match);
        if ($this->checkEmptyMatch($match)) {
            throw new ErrorVideoException("{PiPiGaoXiao} url parsing failed");
        }
        $newGetContentsUrl = 'http://share.ippzone.com/ppapi/share/fetch_content';
        $contents = $this->post($newGetContentsUrl, '{"pid":' . $match[1] . ',"type":"post","mid":null}', [
            'Referer' => $newGetContentsUrl,
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        if ((isset($contents['ret']) && $contents['ret'] != 1) || (isset($contents['data']['post']['imgs'][0]['id']) && !$contents['data']['post']['imgs'][0]['id'])) {
            throw new ErrorVideoException("{PiPiGaoXiao} contents parsing failed");
        }

        $id = $contents['data']['post']['imgs'][0]['id'];

        return $this->returnData(
            $url,
            '',
            '',
            isset($contents['data']['post']['content']) ? $contents['data']['post']['content'] : '',
            "https://file.ippzone.com/img/view/id/{$id}",
            isset($contents['data']['post']['videos'][$id]['url']) ? $contents['data']['post']['videos'][$id]['url'] : '',
            'video'
        );
    }
}