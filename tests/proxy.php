<?php

namespace Smalls\VideoTools\Tests;

use Smalls\VideoTools\Traits\HttpRequest;

require '../vendor/autoload.php';

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/6/10 - 17:11
 **/
class proxy
{
    use HttpRequest;

    public function test()
    {
        //222.186.36.210:3128
        $data = $this->getDaiLiData();
        foreach ($data as $v) {
            var_dump($v);
            var_dump($this->test2($v));
        }
    }

    public function test2($ip)
    {
        return $this->request('get', 'http://api.ipify.org/', [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.25 Mobile Safari/537.36',
            ],
            'timeout' => 5,
            'proxy' => [
                'http' => $ip, // Use this proxy with "http"
                'https' => $ip,
            ]
        ]);
    }

    private function getDaiLiData()
    {
        $data = file_get_contents('http://api.66daili.cn/API/GetCommonProxy/?orderid=1621738062001971042&num=20&token=66daili&format=json&line_separator=win&protocol=http&anonymous=elite&proxytype=https&speed=fast');
        $data = json_decode($data, true);
        return $data['proxies'];
    }

}


//128.199.128.242:8080  45.225.88.132:999
$proxy = new proxy();
//$proxy->test();
var_dump($proxy->test2("221.122.91.75:10286"));