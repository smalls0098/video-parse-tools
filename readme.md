<h1>Smalls</h1>
<p>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/smalls/video-tools"><img src="https://poser.pugx.org/smalls/video-tools/license" alt="License"></a>
</p>

## 短视频去水印
集成了：抖音等等。其他如果需要对接的可以issues

* 技术交流群：1055772768 - 进群密码：smalls

===============
* 2021-06-01：初始化2.0.0版本

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
   返回成功：array
   --
   ````
    class smalls\videoParseTools\parse\model\ParseResponse#55 (6) {
      private $originalUrl =>
      string(29) "https://v.xxxxx.com/JeoLRe4/"
      private $userName =>
      string(11) "xxxxx"
      private $userHeadImg =>
      string(108) "https://p3.xxxxxxx.com/img/tos-cn-i-0813/8abfaad90ed1459fbec4cd464a3d4600~c5_1080x1080.jpeg?from=116350172"
      private $description =>
      string(63) "xxxxxxxxxxxxxx"
      private $videoCover =>
      string(125) "https://p11.xxxxxx.com/img/tos-cn-p-0015/874bdde5eb0949db836a5de27e6e658f_1590144147~c5_300x400.jpeg?from=4257465056_large"
      private $videoUrl =>
      string(414) "http://v26.xxxxxx.com/3b5def4cd873901b323a6fb2e3562820/60b5954a/video/tos/cn/tos-cn-ve-15/c161b5f9f5094fe79f567d03b83db916/?a=1128&br=1767&bt=1767&btag=3&cd=0%7C0%7C0&ch=0&cr=0&cs=0&cv=1&dr=0&ds=6&er=&l=2021060109023101019811215221002A19&lr=&mime_type=video_mp4&net=0&pl=0&qs=0&rc=M3c1Z3ZpM2t0dTMzOWkzM0ApOTtmODY0aTw4Nzo4aWU4OWcpaGRqbGRoaGRmcG9ncmhmXmswXy0tYC0vc3MxYi8wNjIwYzAvXmAzLmI1OmNwb2wrbStqdDo%3D&vl=&vr="
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
  <font>注：仅供学习,切勿用于其他用途，由使用人自行承担因此引发的一切法律责任，作者不承担法律责任。</font> <br>
  **喜欢的话，给个star呗**<br>
  **喜欢的话，给个star呗**<br>
  **喜欢的话，给个star呗**<br>
  
  自己可以参考tests 里面的单元测试（需要在主页面里面调式：小白一枚）<br>
  都无法使用再提issue
  
  
赞助：  
==
感谢JetBrains的支持，推荐大家使用IDE：[PHPSOTRM](https://www.jetbrains.com/?from=video-tools)