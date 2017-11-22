<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\Interfaces\Storage;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use Itxiao6\Upload\Exception\UploadException;
use Itxiao6\Upload\Validation\Code;

/**
 * 七牛文件存储
 * Class Qiniu
 * @package Itxiao6\Upload\Storage
 */
class Qiniu implements Storage
{
    /**
     * 七牛的专属域名
     * @var
     */
    protected $host;
    /**
     * 上传异常信息
     * @var null|array
     */
    protected $exception = null;
    /**
     * 上传接口实现
     * @var UploadManager
     */
    protected $upManager;
    /**
     * 七牛鉴权
     * @var Auth
     */
    protected $auth;

    /**
     * 会话
     * @var
     */
    protected $token;
    /**
     * 七牛储存构造器
     * @param $accessKey
     * @param $secretKey
     * @param $Bucket_Name
     */
    public function __construct($accessKey,$secretKey,$Bucket_Name,$host)
    {
        # 上传接口的实现
        $this -> upManager = new UploadManager();
        # 七牛鉴权
        $this -> auth = new Auth($accessKey, $secretKey);
        # 获取token
        $this -> token = $this -> auth -> uploadToken($Bucket_Name);

        $this -> host = $host;
    }

    /**
     * 创建一个接口
     * @return Qiniu
     */
    public static function create()
    {
        return new self(...func_get_args());
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
     * 七牛上传文件
     * @param $file
     * @param null $validation
     * @return mixed
     */
    public function upload($file, $validation = null)
    {
        # 判断是否为通过Files上传的
        if(!isset($_FILES[$file])){
            # 保存异常信息
            $this -> exception[$file] = new UploadException('要上传的文件不存在');
            return false;
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
        $file_name = self::getARandLetter(15);
        # 上传文件
        list($ret, $error) = $this -> upManager->put($this -> token,$file_name, file_get_contents($_FILES[$file]['tmp_name']));
        if($error!=null){
            $this -> exception[$file] = $error;
        }else{
            return $this -> host.$file_name;
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

    /**
     * 获取七牛云的token
     */
    public function get_token()
    {
        return $this -> token;
    }

    /**
     * 上传多个文件
     * @param $file
     * @param null $validation
     */
    public function uploads($file, $validation = null)
    {
        // TODO: Implement uploads() method.
    }
    public function upload_base64($file, $validation = null)
    {

    }
    public function uploads_base64($file, $validation = null)
    {
        // TODO: Implement uploads_base64() method.
    }
}