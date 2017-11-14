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
        'local'=>Itxiao6\Upload\Storage\Local::class,
        'qiniu'=>Itxiao6\Upload\Storage\Qiniu::class,
        'alioss'=>Itxiao6\Upload\Storage\Alioss::class,
    ];

    /**
     * 获取一个文件上传驱动
     * @param $type 类型
     * @param $param 附带参数
     * @return mixed
     */
    public static function getInterface()
    {
    }

    /**
     * 设置驱动类型
     * @param null | string $name
     * @return bool|null
     */
    public static function set_driver($name = null)
    {
        return self::$driver = ($name===null)?self::$driver:$name;
    }

    /**
     * 添加驱动类
     * @param $name 驱动名称
     * @param $class 类名
     * @return mixed
     */
    public static function add_class($name,$class)
    {
        return self::$class[$name] = $class;
    }
}
