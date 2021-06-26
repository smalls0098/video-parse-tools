<?php


namespace smalls\videoParseTools;

use smalls\videoParseTools\exception\InvalidManagerException;
use smalls\videoParseTools\interfaces\IParse;

/**
 * @author smalls
 * <p>Power：努力努力再努力！！！！！</p>
 * <p>Email：smalls0098@gmail.com</p>
 * <p>Blog：https://www.smalls0098.com</p>
 */
class VideoManager
{

    private $parser;

    private static $videoManager;

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
        if (!self::$videoManager) {
            self::$videoManager = $app;
        } else {
            $app = self::$videoManager;
        }
        return $app->create($method);
    }

    /**
     * @param string $method
     * @return mixed
     * @throws InvalidManagerException
     */
    private function create(string $method)
    {
        if ($this->parser[$method]) {
            return $this->parser[$method];
        }
        $className = __NAMESPACE__ . '\\parse\\factory\\' . $method . "Parse";
        if (!class_exists($className)) {
            throw new InvalidManagerException("the method name does not exist . method : {$method}");
        }
        $make = $this->make($className);
        $this->parser[$method] = $make;
        return $make;
    }

    /**
     * @param string $className
     * @return IParse
     * @throws InvalidManagerException
     */
    private function make(string $className): IParse
    {
        $app = new $className();
        if ($app instanceof IParse) {
            return $app;
        }
        throw new InvalidManagerException("this method does not integrate IVideo . namespace : {$className}");
    }

}