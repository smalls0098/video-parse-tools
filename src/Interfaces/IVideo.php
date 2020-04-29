<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Interfaces;
/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 21:59
 **/
interface IVideo
{

    /**
     * @param string $url
     * @return array
     */
    public function start(string $url): array;

}