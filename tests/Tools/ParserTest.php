<?php


namespace Smalls\Tests\Tools;


use PHPUnit\Framework\TestCase;
use Smalls\VideoTools\VideoManager;

class ParserTest extends TestCase
{

    public function testDouyin()
    {
        $link = 'https://v.douyin.com/eeRkpys/';
        $res = VideoManager::DouYin()->start($link);
        $videoUrl = $res['video_url'] ?? '';
        $this->assertNotEmpty($videoUrl, "抖音视频解析失败，link【{$link}】");
    }

    public function testKuaishou()
    {
        $link = 'https://v.kuaishou.com/9UkwPE';
        $res = VideoManager::KuaiShou()->start($link);
        $videoUrl = $res['video_url'] ?? '';
        $this->assertNotEmpty($videoUrl, "快手视频解析失败，link【{$link}】");
    }

    public function testDouyinHuoshan()
    {
        $link = 'https://share.huoshan.com/hotsoon/s/AUxD0a7zgg8/';
        $res = VideoManager::HuoShan()->start($link);
        $videoUrl = $res['video_url'] ?? '';
        $this->assertNotEmpty($videoUrl, "火山视频解析失败，link【{$link}】");
    }

    public function testToutiao()
    {
        $link = 'https://m.toutiao.com/is/eeR3PQC/';
        $res = VideoManager::TouTiao()->start($link);
        $videoUrl = $res['video_url'] ?? '';
        $this->assertNotEmpty($videoUrl, "头条视频解析失败，link【{$link}】");
    }
}