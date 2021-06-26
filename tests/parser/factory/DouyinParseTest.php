<?php

namespace Smalls\Tests\parser\factory;

use smalls\videoParseTools\parser\factory\DouyinParser;
use PHPUnit\Framework\TestCase;

class DouyinParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://v.douyin.com/JeoLRe4/";
        $parseObj = new DouyinParser();
        $parseResponse = $parseObj->execute($url);
        var_dump($parseResponse);
        $this->assertEquals($url, $parseResponse->getOriginalUrl());
    }
}
