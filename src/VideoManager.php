<?php


namespace smalls\videoParseTools;

use smalls\videoParseTools\exception\InvalidManagerException;
use smalls\videoParseTools\interfaces\IParser;

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

    private static function getManager(): self
    {
        if (!self::$videoManager) {
            $app = new self();
            self::$videoManager = $app;
        } else {
            $app = self::$videoManager;
        }
        return $app;
    }

    /**
     * 通过魔法方法获取解析器对象
     *
     * @param $method string 方法名称
     * @param $params array 方法参数
     * @return IParser
     */
    public static function __callStatic(string $method,
                                        array $params)
    {
        $className = __NAMESPACE__ . '\\parse\\factory\\' . $method . "Parse";
        if (!class_exists($className)) {
            throw new InvalidManagerException("the class does not exist . class : {$className}");
        }
        return self::getManager()->make($className);
    }

    /**
     * 通过自定义对象获取解析器对象
     *
     * @param $class string 对象
     * @return mixed
     */
    public static function customParser(string $class): IParser
    {
        if (!class_exists($class)) {
            throw new InvalidManagerException("the class does not exist . class : {$class}");
        }
        $classImpls = class_implements($class);
        if (!$classImpls) {
            throw new InvalidManagerException("this method does not integrate IParser . class : {$class}");
        }
        $isOk = false;
        foreach ($classImpls as $impl) {
            if ($impl == IParser::class) {
                $isOk = true;
                break;
            }
        }
        if (!$isOk) {
            throw new InvalidManagerException("this method does not integrate IParser . class : {$class}");
        }
        return self::getManager()->make($class);
    }

    /**
     * 通过包名创建对象
     *
     * @param string $className
     * @return IParser
     * @throws InvalidManagerException
     */
    private function make(string $className): IParser
    {
        if ($this->parser[$className]) {
            return $this->parser[$className];
        }
        $app = new $className();
        if ($app instanceof IParser) {
            $this->parser[$className] = $app;
            return $app;
        }
        throw new InvalidManagerException("this method does not integrate IParser . class : {$className}");
    }

}