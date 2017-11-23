<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\Interfaces\Storage;
use OSS\OssClient;
use Itxiao6\Upload\Tools\Tool;
use OSS\Core\OssException;
use Itxiao6\Upload\Exception\UploadException;
use Itxiao6\Upload\Validation\Code;
/**
 * 阿里Oss文件存储
 * Class FileSystem
 * @package Itxiao6\Upload\Storage
 */
class Alioss implements Storage
{

    /**
     * 异常信息
     * @var null|array
     */
    protected $exception = null;

    /**
     * Oss 客户端
     * @var OssClient
     */
    protected $ossClient;
    /**
     * 桶的名字
     * @var
     */
    protected $bucket;



    /**
     * 阿里OSS储存构造器
     * @param $accessKey
     * @param $secretKey
     * @param $Bucket_Name
     * @param $data_host OSS数据中心访问域名
     */
    protected function __construct($accessKey,$secretKey,$Bucket_Name,$data_host)
    {
        try {
            $this -> ossClient = new OssClient($accessKey, $secretKey, $data_host);
        } catch (OssException $e) {
            print $e->getMessage();
        }
        # 存储桶的名字
        $this -> bucket = $Bucket_Name;
        # 返回本对象用于连贯操作
        return $this;
    }

    /**
     * 上传单个文件
     * @param string|array $file
     * @param null|array $validation 验证规则
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
        # 获取随机文件名
        $file_name = self::getARandLetter(15).'.'.explode('/',$_FILES[$file]['type'])[1];
        # 获取新文件名
        $res = $this -> ossClient->putObject($this -> bucket,$file_name,file_get_contents($_FILES[$file]['tmp_name']));
        # 判断是否上传成功
        if(isset($res['info']['url']) && $res['info']['url']!=''){
            return $res['info']['url'];
        }else{
            return false;
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

    public function upload_base64($file, $validation = null)
    {
        // TODO: Implement upload_base64() method.
    }
    public function uploads_base64($file, $validation = null)
    {
        // TODO: Implement uploads_base64() method.
    }
    /**
     * 创建存储器
     * @return AliOss
     */
    public static function create()
    {
        return new self(...func_get_args());
    }

    /**
     * 获取错误信息
     * @param null|string $name
     * @return array|bool
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
     * 获取指定长度的随机字符串
     * @param $num
     * @return string
     */
    protected static function getARandLetter($num){
        $str = '';
        for ($i=0;$i<=$num;$i++){
            $str .= rand(0,555);
        }
        return $str;
    }
}