<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\Storage\Base;
use Itxiao6\Upload\Exception\UploadException;
use Itxiao6\Upload\File;
use InvalidArgumentException;
/**
 * 七牛文件存储
 * Class FileSystem
 * @package Itxiao6\Upload\Storage
 */
class QiniuSystem extends Base
{
    /**
     * 七牛启动
     * @var
     */
    protected static $client;

    /**
     * 七牛储存构造器
     * @param $accessKey
     * @param $secretKey
     * @param $Bucket_Name
     */
    public function __construct($accessKey,$secretKey,$Bucket_Name)
    {
        self::$client = Qiniua::create([
            'access_key' => $accessKey,
            'secret_key' => $secretKey,
            'bucket'     => $Bucket_Name
        ]);
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
        # 七牛长传文件
        if(self::$client -> uploadFile($file->getPathname(),$newName)){
            return true;
        }else{
            return false;
        }
    }
}