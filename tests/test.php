<?php
/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 22:15
 **/

use smalls\videoParseTools\parser\factory\DouyinParser;
use smalls\videoParseTools\parser\factory\HuoshanParser;
use smalls\videoParseTools\VideoManager;

require '../vendor/autoload.php';

//$res = VideoManager::Douyin()
//    ->execute("https://v.douyin.com/JeoLRe4/");
//var_dump($res);

$res = VideoManager::customParser(DouyinParser::class)->execute("https://v.douyin.com/JeoLRe4/");
var_dump($res);