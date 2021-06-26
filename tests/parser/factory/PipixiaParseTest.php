<?php

namespace Smalls\Tests\parser\factory;

use smalls\videoParseTools\parser\factory\PipixiaParser;
use PHPUnit\Framework\TestCase;

class PipixiaParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://h5.pipix.com/s/wkwJBk/";
        $parseObj = new PipixiaParser();
        $parseResponse = $parseObj->execute($url);
        var_dump($parseResponse);
        $this->assertNotEquals("", $parseResponse->getVideoUrl());
    }
}
