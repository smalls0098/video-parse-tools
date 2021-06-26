<?php

namespace Smalls\Tests\parser\factory;

use smalls\videoParseTools\parser\factory\DouyinParser;
use PHPUnit\Framework\TestCase;
use smalls\videoParseTools\parser\factory\ToutiaoParser;

class ToutiaoParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://m.toutiaoimg.cn/group/6862508958330932492/?app=news_article_lite×tamp=1602815645";
        $parseObj = new ToutiaoParser();
        $parseResponse = $parseObj->execute($url);
        var_dump($parseResponse);
        $this->assertEquals($url, $parseResponse->getOriginalUrl());
    }
}
