<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\Storage\Base;
use Itxiao6\Upload\Exception\UploadException;
use Itxiao6\Upload\File;
use InvalidArgumentException;
/**
 * 阿里Oss文件存储
 * Class FileSystem
 * @package Itxiao6\Upload\Storage
 */
class AliOssSystem extends Base
{
    /**
     * web可以访问的url
     * @var
     */
    protected $webUrl;
    /**
     * 阿里OSS驱动
     * @var
     */
    protected static $client;
    /**
     * 阿里OSS的专属域名
     * @var
     */
    protected static $host;

    /**
     * 阿里OSS储存构造器
     * @param $accessKey
     * @param $secretKey
     * @param $Bucket_Name
     */
    public function __construct($accessKey,$secretKey,$Bucket_Name,$host)
    {
        self::$client = Qiniua::create([
            'access_key' => $accessKey,
            'secret_key' => $secretKey,
            'bucket'     => $Bucket_Name
        ]);
        self::$host = $host;
    }
    /**
     * 获取WebUrl
     * @return mixed
     */
    public function getWebUrl(){
        return $this -> webUrl;
    }

    /**
     * Upload
     * @param  File $file The file object to upload
     * @param  string $newName Give the file it a new name
     * @return bool
     * @throws \RuntimeException   If overwrite is false and file already exists
     */
    public function upload(File $file, $newName = null)
    {
        if (is_string($newName)) {
            $fileName = strpos($newName, '.') ? $newName : $newName.'.'.$file->getExtension();

        } else {
            $fileName = $file->getNameWithExtension();
        }

        $newFile = $this->directory . $fileName;
        if ($this->overwrite === false && file_exists($newFile)) {
            $file->addError('File already exists');
            throw new UploadException('File already exists');
        }
        # 阿里OSS上传文件
        if($str = self::$client
            -> uploadFile(
                $file->getPathname(),
                (isset($newName)||$newName==''?
                    $file -> getName().'.'.$file->getExtension()
                    :$newName
                )) -> data['url']){

            # 获取开始的位置
            $start = strripos($str,'/');
            # 设置web访问地址
            $this -> webUrl = rtrim(self::$host,'/').substr($str,$start);
            return true;
        }else{
            return false;
        }
    }
}