<?php
namespace Itxiao6\Upload\Validation;
/**
 * 验证接口
 * Interface Base
 * @package Itxiao6\Upload\Validation
 */
interface Base
{

    /**
     * 获取错误消息
     * @return string
     */
    public function getMessage();

    /**
     * 验证
     * @param $file
     * @return mixed
     */
    public function validation($file);
}
