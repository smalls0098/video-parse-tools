<?php
/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 22:15
 **/

use smalls\videoParseTools\parse\factory\DouyinParse;
use smalls\videoParseTools\parse\factory\HuoshanParse;
use smalls\videoParseTools\VideoManager;

require '../vendor/autoload.php';

//$res = VideoManager::Douyin()
//    ->execute("https://v.douyin.com/JeoLRe4/");
//var_dump($res);

$res = VideoManager::customParser(DouyinParse::class)->execute("https://v.douyin.com/JeoLRe4/");
var_dump($res);