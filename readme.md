<h1>Smalls</h1>
<p>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/license" alt="License"></a>
</p>

## 短视频去水印
集成了：抖音、火山、头条、快手、梨视频、美拍、陌陌、皮皮搞笑、皮皮虾、全民搞笑、刷宝、微视、小咖秀、最右、B站、微博、秒拍等等。其他如果需要对接的可以issues

* 技术交流群：1055772768 - 进群密码：smalls
* 我们已经对接了20个平台的视频提取（部分视频是有水印的，没办法做到无水印）
* 不懂怎么使用可以看一下我的博客。http://www.smalls.vip

===============
* 2020-07-17：更新快速提取无水印视频、添加腾讯视频短视频提取视频
* 2020-06-24：更新抖音提取视频
* 2020-06-14：添加秒拍提取视频，修复美拍提取视频失败
* 2020-06-13：添加微博提取视频（远古视频有水印）
* 2020-06-10：新加代理功能，有点不稳定，有什么好的建议可以issues给我
* 2020-06-10：添加url-validator配置类
* 2020-06-09：全部优化了一下更加面向对象，新加B站解析视频
* 2020-04-29：第一个版本

## 安装

安装方法一：（需要下载composer.phar到根目录，设置PHP为全局变量）
~~~
php composerphar require smalls/video-tools
~~~
安装方法二：
~~~
composer require smalls/video-tools
~~~

如果需要更新扩展包使用
~~~
composer update smalls/video-tools
~~~
 ********
### 日志与发布
[原生PHP演示案例，下载后拉进环境](https://github.com/smalls0098/origin-php-watermark-api)
 ********
> 运行环境要求PHP70+
 
 VideoManager使用文档：(可以参考tests/testphp)
 ==
    抖音：VideoManager::DouYin()->start($url);
    快手：VideoManager::KuaiShou()->start($url);
    火山：VideoManager::HuoShan()->start($url);
    头条：VideoManager::TouTiao()->start($url);
    快手：VideoManager::XiGua()->start($url);
    快手：VideoManager::WeiShi()->start($url);
    皮皮虾：VideoManager::PiPiXia()->start($url);
    最右：VideoManager::ZuiYou()->start($url);
    美拍：VideoManager::MeiPai()->start($url);
    梨视频：VideoManager::LiVideo()->start($url);
    全民搞笑：VideoManager::QuanMingGaoXiao()->start($url);
    皮皮搞笑：VideoManager::PiPiGaoXiao()->start($url);
    陌陌：VideoManager::MoMo()->start($url);
    刷宝：VideoManager::ShuaBao()->start($url);
    小咖秀：VideoManager::XiaoKaXiu()->start($url);
    B站：VideoManager::Bili()->start($url);
    微博：VideoManager::WeiBo()->start($url);
    微博短视频：VideoManager::WeiBo()->newVideoStart($url);
    秒拍：VideoManager::MiaoPai()->start($url);
    B站指定参数：VideoManager::Bili()->setUrl($url)->setQuality(BiliQualityType::LEVEL_2)->execution();
    腾讯视频短视频：VideoManager::QQVideo()->start($url);
   自定义URL配置文件：url-validator
   --
   ````
    例如抖音：$res = VideoManager::KuaiShou([
              'proxy_whitelist' => ['kuaishou'],//白名单，需要提交类名，全部小写
              'proxy' => '$ip:$port',
              'url_validator' => [
                    这边参考config/url-validator.php
              ]
          ])->start($url);
    可以参考config/url-validator.php的格式用参数传递，如果不指定则使用默认的
    不会怎么编写全部使用默认也是可以的
   ````
   返回成功：array
   --
   ````
    array(8) {
       ["md5"]=>
       string(32) "fb0f49b1158923a972d9eed40f97965e"
       ["message"]=>
       string(29) "https://v.kuaishou.com/xxxx"
       ["user_name"]=>
       string(15) "xxxx"
       ["user_head_img"]=>
       string(103) "https://tx2.a.yximgs.com/uhead/AB/2020/04/20/14/xxxxx.jpg"
       ["desc"]=>
       string(46) "小子，xxxxx"
       ["img_url"]=>
       string(139) "https://js2.a.yximgs.com/xxxxx.jpg"
       ["video_url"]=>
       string(144) "https://jsmov2.a.yximgs.com/xxxxx.mp4"
       ["type"]=>
       string(5) "video"
    }
   ````
   返回失败：exception
   --
   ````
       需要进行try-catch
       namespace \Smalls\VideoTools\Exception;
       try {
           $res = VideoManager::KuaiShou()->start("https://v.kuaishou.com/xxxx");
       } catch (ErrorVideoException $e) {
           $e->getTraceAsString();
       }
   ````
  ********
结束：  
==
  <font>注：仅供学习,切勿用于其他用途。</font> <br>
  **喜欢的话，给个star呗**<br>
  **喜欢的话，给个star呗**<br>
  **喜欢的话，给个star呗**<br>
  
  自己可以参考tests/test.php（需要在主页面里面调式：小白一枚）<br>
  都无法使用再提issue
