<?php

namespace Smalls\Tests\parse\factory;

use smalls\videoParseTools\parse\factory\DouyinParse;
use PHPUnit\Framework\TestCase;
use smalls\videoParseTools\parse\factory\ToutiaoParse;

class ToutiaoParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://m.toutiaoimg.cn/group/6862508958330932492/?app=news_article_lite×tamp=1602815645";
        $parseObj = new ToutiaoParse();
        $parseResponse = $parseObj->start($url);
        var_dump($parseResponse);
        $this->assertEquals($url, $parseResponse->getOriginalUrl());
    }
}
