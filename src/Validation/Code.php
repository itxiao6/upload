<?php
namespace Itxiao6\Upload\Validation;
use Itxiao6\Upload\Exception\UploadException;
use Itxiao6\Upload\Validation\Base;

/**
 *
 * Class Code
 * @package Itxiao6\Upload\Validation
 */
class Code implements Base
{
    /**
     * 错误信息
     * @var null
     */
    protected $Message = null;

    /**
     * 错误原因
     * @var array
     */
    protected $error = [
        1=>'上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。',

        2=>'上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。',

        3=>'文件只有部分被上传。',

        4=>'没有文件被上传。',

        6=>'找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进。',

        7=>'文件写入失败。PHP 5.1.0 引进。',
    ];
    /**
     * 获取错误消息
     */
    public function getMessage()
    {
        return $this -> Message;
    }

    /**
     * 验证
     * @param $file
     * @return bool
     * @throws UploadException
     */
    public function validation($file)
    {
        # 验证是否上传成功
        if($file['error']==0){
            return true;
        }
        # 抛出异常
        throw new UploadException($this -> error[$file['error']]);
    }
}