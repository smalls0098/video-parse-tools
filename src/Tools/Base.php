<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;


use Smalls\VideoTools\Common\Common;
use Smalls\VideoTools\Exception\InvalidManagerException;
use Smalls\VideoTools\Utils\Config;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 23:08
 **/
class Base extends Common
{
    /**
     * 解析逻辑层
     * @var Object
     */
    protected $logic;

    /**
     * url验证器
     * @var Config
     */
    protected $urlValidator;

    /**
     * Base constructor.
     * @param $params
     * @return void
     */
    public function __construct($params = [])
    {
        //设置域名验证器
        $config = include __DIR__ . '/../../config/url-validator.php';
        $this->setUrlValidator(new Config($config));
    }

    /**
     * 初始化逻辑对象
     * @throws InvalidManagerException
     * @author smalls
     * @email smalls0098@gmail.com
     */
    public function make()
    {
        //创建逻辑对象
        $className      = str_replace(__NAMESPACE__, "", get_class($this));
        $className      = substr($className, 1);
        $className      = ucfirst($className);
        $logicClassName = $className . 'Logic';
        $logicClassName = str_replace("\\Tools", '\\Logic', __NAMESPACE__) . '\\' . $logicClassName;
        if (!class_exists($logicClassName)) {
            throw new InvalidManagerException("the class does not exist . class name : {$logicClassName}");
        }
        $obj         = new $logicClassName($this, $className);
        $this->logic = $obj;
    }

    /**
     * @return Config
     */
    public function getUrlValidator(): Config
    {
        return $this->urlValidator;
    }

    /**
     * @param Config $urlValidator
     * @return Base
     */
    public function setUrlValidator(Config $urlValidator)
    {
        $this->urlValidator = $urlValidator;
        return $this;
    }


    /**
     * 返回数据结果
     * return data results
     * @param string $url
     * @param string $userName
     * @param string $userHeadPic
     * @param string $desc
     * @param string $videoImage
     * @param string $videoUrl
     * @param string $type
     * @return array
     */
    protected function returnData(string $url, string $userName, string $userHeadPic, string $desc, string $videoImage, string $videoUrl, string $type): array
    {
        return [
            'md5'           => md5($url),
            'message'       => $url,
            'user_name'     => $userName,
            'user_head_img' => $userHeadPic,
            'desc'          => $desc,
            'img_url'       => $videoImage,
            'video_url'     => $videoUrl,
            'type'          => $type
        ];
    }

    /**
     * 导出结果数据
     * @return array
     */
    protected function exportData()
    {
        return $this->returnData(
            $this->logic->getUrl(),
            $this->logic->getUsername(),
            $this->logic->getUserPic(),
            $this->logic->getVideoDesc(),
            $this->logic->getVideoImage(),
            $this->logic->getVideoUrl(),
            'video'
        );
    }

}