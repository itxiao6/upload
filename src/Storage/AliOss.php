<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\Interfaces\Storage;
use OSS\OssClient;
use OSS\Core\OssException;
/**
 * 阿里Oss文件存储
 * Class FileSystem
 * @package Itxiao6\Upload\Storage
 */
class AliOss implements Storage
{

    /**
     * 异常信息
     * @var null|array
     */
    protected $exception = null;



    /**
     * 阿里OSS储存构造器
     * @param $accessKey
     * @param $secretKey
     * @param $Bucket_Name
     * @param $host web 访问域名
     * @param $vpc_host 内网域名
     * @param $loca_host 经典网络内网域名
     */
    protected function __construct($accessKey,$secretKey,$Bucket_Name,$host,$vpc_host,$loca_host)
    {
        $accessKeyId = "<AccessKeyID that you obtain from OSS>";
        $accessKeySecret = "<AccessKeySecret that you obtain from OSS>";
        $endpoint = "<Domain that you select to access an OSS data center, such as \"oss-cn-hangzhou.aliyuncs.com>";
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        } catch (OssException $e) {
            print $e->getMessage();
        }
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

    public function upload($file, $validation = null)
    {
        // TODO: Implement upload() method.
    }

    public function uploads($file, $validation = null)
    {
        // TODO: Implement uploads() method.
    }

    public function upload_base64($file, $validation = null)
    {
        // TODO: Implement upload_base64() method.
    }
    public function uploads_base64($file, $validation = null)
    {
        // TODO: Implement uploads_base64() method.
    }
}