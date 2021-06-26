<?php


namespace smalls\videoParseTools\parse\factory;


use smalls\videoParseTools\enums\UserAgentType;
use smalls\videoParseTools\exception\InvalidParseException;
use smalls\videoParseTools\parse\AbstractParse;
use smalls\videoParseTools\utils\CommonUtil;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
class PipixiaParse extends AbstractParse
{

    public function handle()
    {
        $pid = $this->getPID();
        $contents = $this->getContents($pid);

        $id       = $contents['data']['post']['imgs'][0]['id'] ?? '';
        if (!$id) {
            throw new InvalidParseException("获取不到id参数信息");
        }
    }

    public function getContents(string $pid)
    {
        $newGetContentsUrl = 'https://share.izuiyou.com/api/post/detail';
        return $this->post($newGetContentsUrl, '{"pid":' . $pid . '}', [
            'Referer'    => $newGetContentsUrl,
            'User-Agent' => UserAgentType::ANDROID_USER_AGENT,
        ]);
    }

    private function getPID(): string
    {
        if (strpos($this->originalUrl, 'hybrid/share/post')) {
            preg_match('/hybrid\/share\/post\?pid=([0-9]+)&/i', $this->originalUrl, $match);
        } elseif (strpos($this->url, '/detail/')) {
            preg_match('/detail\/([0-9]+)\/?/i', $this->originalUrl, $match);
        } else {
            throw new InvalidParseException("提交的域名不符合格式");
        }
        if (CommonUtil::checkEmptyMatch($match)) {
            throw new InvalidParseException("获取不到pid参数信息");
        }
        return $match[1];
    }
}