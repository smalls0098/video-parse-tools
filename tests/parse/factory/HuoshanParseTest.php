<?php

namespace Smalls\Tests\parse\factory;

use smalls\videoParseTools\parse\factory\HuoshanParse;
use PHPUnit\Framework\TestCase;

class HuoshanParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://share.huoshan.com/hotsoon/s/Y6I1b80eNi8/";
        $parseObj = new HuoshanParse();
        $parseResponse = $parseObj->start($url);
        var_dump($parseResponse);
        $this->assertNotEquals("", $parseResponse->getVideoUrl());
    }
}
