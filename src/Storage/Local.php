<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\Interfaces\Storage;
use Itxiao6\Upload\Validation\Code;

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
     * @param $file
     * @param array $validation
     * @return string
     * @throws \Exception
     */
    public function upload($example,$file, $validation = null)
    {
        # 判断是否为通过Files上传的
        if(!isset($_FILES[$file])){
//            throw new UploadException('要上传的文件不存在');
        }
        if($validation == null){
            # 默认的验证规则
            $validation = [new Code()];
        }
        # 判断是否存在验证
        if($validation!=null){
            # 循环处理验证规则
            foreach ($validation as $item){
                # 判断验证结果
                if(!$validation -> validation($_FILES[$file])){
                    # 抛出异常
//                    throw new UploadException($validation -> getMessage());
                }
            }
        }
        # 获取新文件名
        $newName = $this -> getARandLetter(15).'.'.explode('/',$_FILES[$file]['type'])[1];
        # 上传文件
        if(!$this -> moveUploadedFile($_FILES[$file]['tmp_name'],$this -> directory.$newName)){
//            throw new UploadException('文件上传失败');
        }
        # 返回上传结果
        return $this -> webUrl.$newName;
    }

    /**
     * 获取指定长度的随机字符串
     * @param $num
     * @return string
     */
    public function getARandLetter($num){
        $str = '';
        for ($i=0;$i<=$num;$i++){
            $str .= rand(0,555);
        }
        return $str;
    }

    /**
     * 上传多个文件
     * @param $example
     * @param $file
     * @param null $validation
     */
    public function uploads($example,$file, $validation = null)
    {
//        TODO 整理二维数组
//        TODO 循环调用上传文件
//        TODO 拼接数组 并返回
    }

    /**
     * 上传一个base64类型的文件
     * @param $example
     * @param $file
     * @param null $validation
     */
    public function upload_base64($example, $file, $validation = null)
    {
        // TODO: Implement upload_base64() method.
    }

    /**
     * 上传多个base64类型的文件
     * @param $example
     * @param $file
     * @param null $validation
     */
    public function uploads_base64($example, $file, $validation = null)
    {
        // TODO: Implement uploads_base64() method.
    }

    /**
     * base字符转 文件
     */
    public function base64_to_file()
    {

    }

    /**
     * 从临时目录复制文件到目标文件夹
     *
     * @param  string $source      源文件
     * @param  string $destination 新文件
     * @return bool
     */
    protected function moveUploadedFile($source, $destination)
    {
        return copy($source,$destination);
    }
}
