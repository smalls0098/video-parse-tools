<?php

namespace Smalls\Tests\parse\factory;

use smalls\videoParseTools\parse\factory\DouyinParse;
use PHPUnit\Framework\TestCase;
use smalls\videoParseTools\parse\factory\ToutiaoParse;
use smalls\videoParseTools\parse\factory\XiguaParse;

class XiguaParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://v.ixigua.com/JPk2Mxb/";
        $parseObj = new XiguaParse();
        $parseResponse = $parseObj->start($url);
        var_dump($parseResponse);
        $this->assertEquals($url, $parseResponse->getOriginalUrl());
    }
}
