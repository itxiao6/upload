<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\Interfaces\Storage;
use Itxiao6\Upload\Tools\Tool;
use Itxiao6\Upload\Validation\Code;
use Itxiao6\Upload\Exception\UploadException;

/**
 * 本地文件存储
 * Class FileSystem
 * @package Itxiao6\Upload\Storage
 */
class Local implements Storage
{
    /**
     * web可以访问的url
     * @var
     */
    protected $webUrl;
    /**
     * 上传文件夹
     * @var string
     */
    protected $directory;
    /**
     * 异常信息
     * @var null|array
     */
    protected $exception = null;

    /**
     * 本地文件存储器
     * @param $directory
     * @param $webUrl
     */
    protected function __construct($directory,$webUrl)
    {
        # 上传文件夹
        $this -> directory = $directory;
        # web 访问目录
        $this -> webUrl = $webUrl;
        return $this;
    }

    /**
     * 创建一个上传驱动
     * @return mixed
     */
    public static function create()
    {
        return new self(...func_get_args());
    }

    /**
     * 上传文件
     * @param string|array$file
     * @param null $validation
     * @return bool|string
     */
    public function upload($file, $validation = null)
    {
        # 判断是否为数组
        if(is_array($file)){
            $_FILES[$file['name']] = $file;
            $file = $file['name'];
        }else{
            # 判断是否为通过Files上传的
            if(!isset($_FILES[$file])){
                # 保存异常信息
                $this -> exception[$file] = new UploadException('要上传的文件不存在');
                return false;
            }
        }
        # 验证验证规则
        try{
            if($validation == null){
                # 默认的验证规则
                $validation = [new Code()];
            }
            # 判断是否存在验证
            if($validation!=null){
                # 循环处理验证规则
                foreach ($validation as $item){
                    # 验证
                    $item -> validation($_FILES[$file]);
                }
            }
        }catch (UploadException $exception){
            # 保存异常信息
            $this -> exception[$file] = $exception;
            return false;
        }
        # 获取新文件名
        $newName = Tool::getARandLetter(15).'.'.explode('/',$_FILES[$file]['type'])[1];
        # 上传文件
        if(!self::moveUploadedFile($_FILES[$file]['tmp_name'],$this -> directory.$newName)){
            # 保存异常信息
            $this -> exception[$file] = new UploadException('文件上传失败');
            return false;
        }
        # 返回上传结果
        return $this -> webUrl.$newName;
    }

    /**
     * 获取错误信息
     * @param null | string $name
     * @return array | string
     */
    public function get_error_message($name = null)
    {
        if($name!=null){
            return $this -> exception[$name] -> getMessage();
        }else{
            if($this -> exception === null){
                return false;
            }
            $message = [];
            foreach ($this -> exception as $item) {
                $message[] = $item -> getMessage();
            }
            return $message;
        }
    }

    /**
     * 上传多个文件
     * @param $file
     * @param null $validation
     * @return array|bool|string
     */
    public function uploads($file, $validation = null)
    {
        $files = [];
        foreach (Tool::files_to_item($file) as $key=>$item){
            $files[] = $this -> upload($item,$validation);
        }
        return $files;
    }

    /**
     * 上传一个base64类型的文件
     * @param $file
     * @param null $validation
     * @return bool|string
     */
    public function upload_base64($file, $validation = null)
    {
        # 上传文件
        return $this -> upload(Tool::base64_to_file($file,$validation));
    }

    /**
     * 上传多个base64类型的文件
     * @param $file
     * @param null $validation
     * @return array|bool|string
     */
    public function uploads_base64( $file, $validation = null)
    {
        # 定义上传结果
        $result = [];
        # 判断是否为多个文件
        if(is_array($file)){
            # 循环上传文件
            foreach ($file as $name=>$item){
                # 累加上传结果
                $result[$name] = $this -> upload_base64($item,$validation);
            }
        }else{
            # 返回一个文件的上传结果
            return $this -> upload_base64($file,$validation);
        }
        # 返回上传结果
        return $result;
    }

    /**
     * 从临时目录复制文件到目标文件夹
     *
     * @param  string $source      源文件
     * @param  string $destination 新文件
     * @return bool
     */
    protected static function moveUploadedFile($source, $destination)
    {
        return copy($source,$destination);
    }
}
