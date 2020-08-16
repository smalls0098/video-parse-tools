<?php
declare (strict_types=1);

namespace Smalls\VideoTools;

use Smalls\VideoTools\Exception\InvalidManagerException;
use Smalls\VideoTools\Interfaces\IVideo;
use Smalls\VideoTools\Tools\Bili;
use Smalls\VideoTools\Tools\DouYin;
use Smalls\VideoTools\Tools\HuoShan;
use Smalls\VideoTools\Tools\KuaiShou;
use Smalls\VideoTools\Tools\LiVideo;
use Smalls\VideoTools\Tools\MeiPai;
use Smalls\VideoTools\Tools\MiaoPai;
use Smalls\VideoTools\Tools\MoMo;
use Smalls\VideoTools\Tools\PiPiGaoXiao;
use Smalls\VideoTools\Tools\PiPiXia;
use Smalls\VideoTools\Tools\QQVideo;
use Smalls\VideoTools\Tools\QuanMingGaoXiao;
use Smalls\VideoTools\Tools\ShuaBao;
use Smalls\VideoTools\Tools\TaoBao;
use Smalls\VideoTools\Tools\TouTiao;
use Smalls\VideoTools\Tools\WeiBo;
use Smalls\VideoTools\Tools\WeiShi;
use Smalls\VideoTools\Tools\XiaoKaXiu;
use Smalls\VideoTools\Tools\XiGua;
use Smalls\VideoTools\Tools\ZuiYou;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 21:51
 **/

/**
 * @method static HuoShan HuoShan(...$params)
 * @method static DouYin DouYin(...$params)
 * @method static KuaiShou KuaiShou(...$params)
 * @method static TouTiao TouTiao(...$params)
 * @method static XiGua XiGua(...$params)
 * @method static WeiShi WeiShi(...$params)
 * @method static PiPiXia PiPiXia(...$params)
 * @method static ZuiYou ZuiYou(...$params)
 * @method static MeiPai MeiPai(...$params)
 * @method static LiVideo LiVideo(...$params)
 * @method static QuanMingGaoXiao QuanMingGaoXiao(...$params)
 * @method static PiPiGaoXiao PiPiGaoXiao(...$params)
 * @method static MoMo MoMo(...$params)
 * @method static ShuaBao ShuaBao(...$params)
 * @method static XiaoKaXiu XiaoKaXiu(...$params)
 * @method static Bili Bili(...$params)
 * @method static WeiBo WeiBo(...$params)
 * @method static MiaoPai MiaoPai(...$params)
 * @method static QQVideo QQVideo(...$params)
 * @method static TaoBao TaoBao(...$params)
 */
class VideoManager
{

    public function __construct()
    {
    }

    /**
     * @param $method
     * @param $params
     * @return mixed
     */
    public static function __callStatic($method, $params)
    {
        $app = new self();
        return $app->create($method, $params);
    }

    /**
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws InvalidManagerException
     */
    private function create(string $method, array $params)
    {
        $className = __NAMESPACE__ . '\\Tools\\' . $method;
        if (!class_exists($className)) {
            throw new InvalidManagerException("the method name does not exist . method : {$method}");
        }
        return $this->make($className, $params);
    }

    /**
     * @param string $className
     * @param array $params
     * @return mixed
     * @throws InvalidManagerException
     */
    private function make(string $className, array $params)
    {
        $app = new $className($params);
        if ($app instanceof IVideo) {
            return $app;
        }
        throw new InvalidManagerException("this method does not integrate IVideo . namespace : {$className}");
    }
}