<?php
declare (strict_types=1);

namespace Smalls\VideoTools\Tools;

use Smalls\VideoTools\Utils\Config;

/**
 * Created By 1
 * Author：smalls
 * Email：smalls0098@gmail.com
 * Date：2020/4/26 - 23:08
 **/
class Base
{

    protected $logic;

    /**
     * url验证列表
     * @var Config
     */
    protected $urlValidator;

    /**
     * 公共配置列表
     * @var Config
     */
    protected $config;

    /**
     * Base constructor.
     * @param $params
     */
    public function __construct($params = [])
    {
        list($params) = $params;
        $this->config = new Config($params);
        if (!array_key_exists('url-validators', $params)) {
            $config = include __DIR__ . '/../../config/url-validator.php';
            $this->urlValidator = new Config($config);
        } else {
            $this->urlValidator = $params['url_validator'];
        }
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
            'md5' => md5($url),
            'message' => $url,
            'user_name' => $userName,
            'user_head_img' => $userHeadPic,
            'desc' => $desc,
            'img_url' => $videoImage,
            'video_url' => $videoUrl,
            'type' => $type
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