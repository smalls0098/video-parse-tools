<?php


namespace Smalls\Tests\Tools;


use PHPUnit\Framework\TestCase;
use Smalls\VideoTools\Enumerates\WeiboQualityType;
use Smalls\VideoTools\VideoManager;

class ParserTest extends TestCase
{

    /**
     * 抖音
     */
    public function testDouyin()
    {
        $link = 'https://v.douyin.com/eeRkpys/';
        $res = VideoManager::DouYin()->start($link);
        $videoUrl = $res['video_url'] ?? '';
        $this->assertNotEmpty($videoUrl, "抖音视频解析失败，link【{$link}】");
    }

    /**
     * 快手
     */
    public function testKuaishou()
    {
        $link = 'https://v.kuaishou.com/cYU9ZW';
        $res = VideoManager::KuaiShou()->start($link);
        $videoUrl = $res['video_url'] ?? '';
        $this->assertNotEmpty($videoUrl, "快手视频解析失败，link【{$link}】");
    }

    /**
     * 火山
     */
    public function testDouyinHuoshan()
    {
        $link = 'https://share.huoshan.com/hotsoon/s/AUxD0a7zgg8/';
        $res = VideoManager::HuoShan()->start($link);
        $videoUrl = $res['video_url'] ?? '';
        $this->assertNotEmpty($videoUrl, "火山视频解析失败，link【{$link}】");
    }

    /**
     * 头条 放弃
     */
//    public function testToutiao()
//    {
//        $link = 'https://m.toutiao.com/is/eeR3PQC/';
//        $res = VideoManager::TouTiao()->start($link);
//        $videoUrl = $res['video_url'] ?? '';
//        $this->assertNotEmpty($videoUrl, "头条视频解析失败，link【{$link}】");
//    }

    /**
     * 微博
     */
    public function testWeibo()
    {
        $link = 'https://video.weibo.com/show?fid=1034:4609376808534059';
        $res = VideoManager::WeiBo()->start($link);
        $videoUrl = $res['video_url'] ?? '';
        $this->assertNotEmpty($videoUrl, "头条视频解析失败，link【{$link}】");
    }

    /**
     * 微博 - 设置视频质量
     */
    public function testWeiboQuality()
    {
        $link = "https://video.weibo.com/show?fid=1034:4611048767160360";
        $res = VideoManager::WeiBo()->setQuality(WeiboQualityType::QUALITY_720P)->start($link);
        $videoUrl = $res['video_url'] ?? '';
        $this->assertNotEmpty($videoUrl, "头条视频解析失败，link【{$link}】");
    }
}