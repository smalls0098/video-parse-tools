<?php

namespace Smalls\Tests\parse\factory;

use smalls\videoParseTools\parse\factory\MeipaiParse;
use PHPUnit\Framework\TestCase;

class MeipaiParseTest extends TestCase
{
    public function testHandle()
    {
        $url = "http://www.meipai.com/media/1200571483?client_id=1089857302&utm_media_id=1200571483&utm_source=meipai_share&utm_term=meipai_android&gid=2211243272";
        $parseObj = new MeipaiParse();
        $parseResponse = $parseObj->execute($url);
        var_dump($parseResponse);
        $this->assertNotEquals("", $parseResponse->getVideoUrl());
    }
}
