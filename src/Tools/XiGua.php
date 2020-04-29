<?php

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Exception\ErrorVideoException;
use Smalls\VideoTools\Interfaces\IVideo;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/27 - 14:32
 **/
class XiGua extends TouTiao implements IVideo
{

    /**
     * @param string $url
     * @return array
     * @throws ErrorVideoException
     */
    public function start(string $url): array
    {
        if (empty($url)) {
            throw new ErrorVideoException("{XiGua} url cannot be empty");
        }
        if (strpos($url, "xigua.com") == false) {
            throw new ErrorVideoException("{XiGua} the URL must contain one of the domain names xigua.com to continue execution");
        }
        preg_match('/group\/([0-9]+)\/?/i', $url, $match);
        if ($this->checkEmptyMatch($match)) {
            throw new ErrorVideoException("{XiGua} url parsing failed");
        }

        return $this->getContents($url, $match[1]);
    }
}