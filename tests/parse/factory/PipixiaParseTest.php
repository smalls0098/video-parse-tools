<?php

namespace Smalls\Tests\parse\factory;

use smalls\videoParseTools\parse\factory\PipixiaParse;
use PHPUnit\Framework\TestCase;

class PipixiaParseTest extends TestCase
{

    public function testHandle()
    {
        $url = "https://h5.pipix.com/s/wkwJBk/";
        $parseObj = new PipixiaParse();
        $parseResponse = $parseObj->execute($url);
        var_dump($parseResponse);
        $this->assertNotEquals("", $parseResponse->getVideoUrl());
    }
}
