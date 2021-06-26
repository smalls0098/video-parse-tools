<?php

namespace Smalls\Tests\parser\factory;

use smalls\videoParseTools\parser\factory\DouyinParser;
use PHPUnit\Framework\TestCase;
use smalls\videoParseTools\parser\factory\ToutiaoParser;
use smalls\videoParseTools\parser\factory\XiguaParse;

class XiguaParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://v.ixigua.com/JPk2Mxb/";
        $parseObj = new XiguaParse();
        $parseResponse = $parseObj->execute($url);
        var_dump($parseResponse);
        $this->assertEquals($url, $parseResponse->getOriginalUrl());
    }
}
