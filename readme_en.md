# parse the original video
integrated：DouYin、HuoShan、TouTiao、KuaiShou、LiVideo、MeiPai、MoMo、PiPiGaoXiao、PiPiXia、QuanMingGaoXiao、ShuaBao、WeiShi、XiaoKaXiu、ZuiYou

2020-04-29：first version

install：  
==
    composer require smalls/video-tools
 ********
 ***PHP>=7*
 
 VideoManager doc：(reference:tests/test.php)
 ==
    DouYin：VideoManager::DouYin()->start($url);
    KuaiShou：VideoManager::KuaiShou()->start($url);
    HuoShan：VideoManager::HuoShan()->start($url);
    TouTiao：VideoManager::TouTiao()->start($url);
    XiGua：VideoManager::XiGua()->start($url);
    WeiShi：VideoManager::WeiShi()->start($url);
    PiPiXia：VideoManager::PiPiXia()->start($url);
    ZuiYou：VideoManager::ZuiYou()->start($url);
    MeiPai：VideoManager::MeiPai()->start($url);
    LiVideo：VideoManager::LiVideo()->start($url);
    QuanMingGaoXiao：VideoManager::QuanMingGaoXiao()->start($url);
    PiPiGaoXiao：VideoManager::PiPiGaoXiao()->start($url);
    MoMo：VideoManager::MoMo()->start($url);
    ShuaBao：VideoManager::ShuaBao()->start($url);
    XiaoKaXiu：VideoManager::XiaoKaXiu()->start($url);
   return success：array
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
   return failed：exception
   --
   ````
       try-catch
       namespace \Smalls\VideoTools\Exception;
       try {
           $res = VideoManager::KuaiShou()->start("https://v.kuaishou.com/xxxx");
       } catch (ErrorVideoException $e) {
           $e->getTraceAsString();
       }
   ````
  ********
end：  
==
  <font>note: For learning only, do not use for other purposes.</font> <br>
  **if you like, give a star**<br>
  **if you like, give a star**<br>
  **if you like, give a star**<br>
  
  reference:tests/test.php<br>
  can't use it again issue