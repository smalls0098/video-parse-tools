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
class ZuiYou extends Base implements IVideo
{

    /**
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{ZuiYou} url cannot be empty");
        }
        if (strpos($url, "izuiyou.com") == false) {
            throw new ErrorVideoException("{ZuiYou} the URL must contain one of the domain names izuiyou.com to continue execution");
        }
        preg_match('/detail\/([0-9]+)\/?/i', $url, $match);
        if ($this->checkEmptyMatch($match)) {
            throw new ErrorVideoException("{ZuiYou} url parsing failed");
        }

        $newGetContentsUrl = 'https://share.izuiyou.com/api/post/detail';
        $contents = $this->post($newGetContentsUrl, '{"pid":' . $match[1] . '}', [
            'Referer' => $newGetContentsUrl,
            'User-Agent' => self::ANDROID_USER_AGENT,
        ]);

        if ((isset($contents['ret']) && $contents['ret'] != 1) || (isset($contents['data']['post']['imgs'][0]['id']) && $contents['data']['post']['imgs'][0]['id'] == null)) {
            throw new ErrorVideoException("{ZuiYou} contents parsing failed");
        }

        $id = $contents['data']['post']['imgs'][0]['id'];

        return $this->returnData(
            $url,
            isset($contents['data']['post']['member']['name']) ? $contents['data']['post']['member']['name'] : '',
            isset($contents['data']['post']['member']['avatar_urls']['aspect_low']['urls'][0]) ? ['data']['post']['member']['avatar_urls']['aspect_low']['urls'][0] : '',
            isset($contents['data']['post']['content']) ? $contents['data']['post']['content'] : '',
            isset($contents['data']['post']['imgs'][0]['urls']['origin']['urls'][0]) ? $contents['data']['post']['imgs'][0]['urls']['origin']['urls'][0] : $contents['data']['post']['videos'][$id]['cover_urls'][0],
            isset($contents['data']['post']['imgs'][0]['urls']['origin']['urls'][0]) ? $contents['data']['post']['imgs'][0]['urls']['origin']['urls'][0] : $contents['data']['post']['videos'][$id]['url'],
            'video'
        );
    }
}