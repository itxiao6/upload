<?php
namespace Itxiao6\Upload;

/**
 * 文件上传包(主入口)
 * Class Upload
 * @package Itxiao6\Upload
 */
class Upload
{
    /**
     * 实例池
     * @var array
     */
    protected static $example = [];
    /**
     * 目前使用的驱动
     * @var bool
     */
    protected static $driver = 'Local';
    /**
     * 接口
     * @var array
     */
    protected static $interfaces = [
        'Local'=>\Itxiao6\Upload\Storage\Local::class,
        'Qiniu'=>\Itxiao6\Upload\Storage\Qiniu::class,
        'Alioss'=>\Itxiao6\Upload\Storage\Alioss::class,
    ];

    /**
     * 获取现有的接口
     * @return array
     */
    public static function get_interface()
    {
        return self::$interfaces;
    }

    /**
     * 设置接口
     * @param $name
     * @param null $class
     * @return int|null
     */
    public static function set_interface($name,$class = null)
    {
        if($class === null){
            return self::$interfaces = array_push(self::$interfaces,$name);
        }
        return self::$interfaces[$name] = $class;
    }

    /**
     * 装饰者(指向制定的 存储器)
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::$example[self::$driver] -> $name(...$arguments);
    }

    /**
     * 启动上传组件
     */
    public static function start()
    {
        # 判断驱动是否存在
        if(!isset(self::$interfaces[self::$driver])){
            return false;
        }
        return self::$example[self::$driver] = self::$interfaces[self::$driver]::create(...func_get_args());
    }

    /**
     * 设置文件上传驱动
     * @param null | string $name
     * @return bool|null
     */
    public static function set_driver($name = null)
    {
        return self::$driver = ($name===null)?self::$driver:$name;
    }

    /**
     * 获取目前的驱动
     * @return bool
     */
    public static function get_driver()
    {
        return self::$driver;
    }
}
