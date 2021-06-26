<?php

namespace Smalls\Tests\parser\factory;

use smalls\videoParseTools\parser\factory\WeishiParser;
use PHPUnit\Framework\TestCase;

class WeishiParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://h5.weishi.qq.com/weishi/feed/6Z7Uxwu7H1JsBFXPo/wsfeed?wxplay=1&id=6Z7Uxwu7H1JsBFXPo&collectionid=1bc8fe60a09dce07a4c5ce449b3c16bf&spid=8404838818534879236&qua=v1_and_weishi_6.7.6_588_312027000_d&chid=100081003&pkg=&attach=cp_reserves3_1000370721";
        $parseObj = new WeishiParser();
        $parseResponse = $parseObj->execute($url);
        var_dump($parseResponse);
        $this->assertEquals($url, $parseResponse->getOriginalUrl());
    }
}
