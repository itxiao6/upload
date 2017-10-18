<?php
namespace Itxiao6\Upload;
use Itxiao6\Upload\Storage\Local;
use Itxiao6\Upload\Storage\Qiniu;
use Itxiao6\Upload\Storage\Alioss;

/**
 * 文件处理
 * Class Upload
 * @package Itxiao6\Upload
 */
class Upload
{
    /**
     * 驱动
     * @var bool
     */
    protected static $driver = false;
    /**
     * 接口
     * @var array
     */
    protected static $class = [
        'local'=>Local::class,
        'qiniu'=>Qiniu::class,
        'alioss'=>Alioss::class,
    ];

    /**
     * 获取一个文件上传驱动
     * @param $type 类型
     * @param $param 附带参数
     * @return mixed
     */
    public static function getInterface($type,$param)
    {
        if(!isset(self::$driver[$type])){
            self::$driver[$type] = new self::$class[$type]($param);
        }
        return self::$driver[$type];
    }

    /**
     * 添加驱动类
     * @param $name
     * @param $class
     */
    public static function add_class($name,$class)
    {
        return self::$class[$name] = $class;
    }
}
