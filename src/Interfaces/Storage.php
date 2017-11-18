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
     * 上传单个文件
     * @param $example
     * @return mixed
     */
    public function upload($file, $validation = null);

    /**
     * 上传多个文件
     * @param $example
     * @return mixed
     */
    public function uploads($file, $validation = null);

    /**
     * 上传一个base64格式的文件
     * @param $example
     * @return mixed
     */
    public function upload_base64($file, $validation = null);

    /**
     * 上传多个base64格式的文件
     * @param $example
     * @return mixed
     */
    public function uploads_base64($file, $validation = null);
}