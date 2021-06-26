<?php

namespace Smalls\Tests\parser\factory;

use smalls\videoParseTools\parser\factory\HuoshanParser;
use PHPUnit\Framework\TestCase;

class HuoshanParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://share.huoshan.com/hotsoon/s/Y6I1b80eNi8/";
        $parseObj = new HuoshanParser();
        $parseResponse = $parseObj->execute($url);
        var_dump($parseResponse);
        $this->assertNotEquals("", $parseResponse->getVideoUrl());
    }
}
