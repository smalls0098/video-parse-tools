<h1>Smalls</h1>
<p>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/license" alt="License"></a>
</p>

## 短视频去水印
集成了：抖.音、火.山、头.条、快.手、梨.视.频、美.拍、陌.陌、皮.皮.搞.笑、皮.皮.虾、全.民.搞.笑、刷.宝、微.视、小.咖.秀、最.右、B.站等等。其他如果需要对接的可以issues

===============
* 2020-06-10：新加代理功能，有点不稳定，有什么好的建议可以issues给我
* 2020-06-10：添加url-validator配置类
* 2020-06-09：全部优化了一下更加面向对象，新加B.站视频解析
* 2020-04-29：第一个版本

## 安装

~~~
composer require smalls/video-tools
~~~

如果需要更新扩展包使用
~~~
composer update smalls/video-tools
~~~
 ********
> 运行环境要求PHP7.0+
 
 VideoManager使用文档：(可以参考tests/test.php)
 ==
    抖.音：VideoManager::DouYin()->start($url);
    快.手：VideoManager::KuaiShou()->start($url);
    火.山：VideoManager::HuoShan()->start($url);
    头.条：VideoManager::TouTiao()->start($url);
    快.手：VideoManager::XiGua()->start($url);
    快.手：VideoManager::WeiShi()->start($url);
    皮.皮.虾：VideoManager::PiPiXia()->start($url);
    最.右：VideoManager::ZuiYou()->start($url);
    美.拍：VideoManager::MeiPai()->start($url);
    梨.视.频：VideoManager::LiVideo()->start($url);
    全.民.搞.笑：VideoManager::QuanMingGaoXiao()->start($url);
    皮.皮.搞.笑：VideoManager::PiPiGaoXiao()->start($url);
    陌.陌：VideoManager::MoMo()->start($url);
    刷.宝：VideoManager::ShuaBao()->start($url);
    小.咖.秀：VideoManager::XiaoKaXiu()->start($url);
    B.站：VideoManager::Bili()->start($url);
    B.站.指定参数：VideoManager::Bili()->setUrl($url)->setQuality(BiliQualityType::LEVEL_2)->execution();
   自定义配置文件：url-validator
   --
   ````
    例如抖.音：$res = VideoManager::KuaiShou([
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