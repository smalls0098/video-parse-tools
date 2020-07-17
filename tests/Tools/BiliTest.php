<?php

namespace Smalls\Tests\Tools;

use PHPUnit\Framework\TestCase;
use Smalls\VideoTools\Enumerates\BiliQualityType;
use Smalls\VideoTools\VideoManager;

class BiliTest extends TestCase
{

    public function testStart()
    {
        $res = VideoManager::Bili()->setUrl("https://b23.tv/av84665662")->setQuality(BiliQualityType::LEVEL_2)->execution();
        var_dump($res);
    }
}
