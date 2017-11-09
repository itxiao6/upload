<?php
namespace Itxiao6\Upload\Interfaces;

/**
 * 文件上传驱动接口约束
 * Interface Storage
 * @package Itxiao6\Upload\Interfaces
 */
interface Storage
{
    /**
     * 上传一个文件
     * @param $file
     * @return mixed
     */
    public function upload($file);

    /**
     * 上传多个文件
     * @param $files
     * @return mixed
     */
    public function uploads($files);
}