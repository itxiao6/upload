<?php
namespace Itxiao6\Upload\Storage;
use Itxiao6\Upload\Interfaces\Upload;

/**
 * 本地文件存储
 * Class FileSystem
 * @package Itxiao6\Upload\Storage
 */
class Local implements Upload
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
     * Local constructor.
     * @param $param
     */
    public function __construct($param)
    {
        # 上传文件夹
        $this -> directory = $param['directory'];
        # web 访问目录
        $this -> webUrl = $param['webUrl'];
    }

    /**
     * @param $file
     * @param null $newName
     * @return bool
     */
    public function upload($file, $newName = null)
    {
        # 判断是否为通过Files上传的
        if(!isset($_FILES[$file])){
            throw new \Exception('要上传的文件不存在');
        }

        # 获取新文件名
        if($newName==null){
            $newName = $this -> getARandLetter(15).'.'.explode('/',$_FILES[$file]['type'])[1];
        }
        # 上传文件
        if(!$this->moveUploadedFile($_FILES[$file]['tmp_name'],$this -> directory.$newName)){
            throw new \Exception('文件上传失败');
        }
        # 返回上传结果
        return $this -> webUrl.$newName;
    }

    public function getARandLetter($num){
        $str = '';
        for ($i=0;$i<=$num;$i++){
            $str .= rand(0,555);
        }
        return $str;
    }
    /**
     * @param $file
     * @param null $newName
     * @return bool
     */
    public function uploads($file, $newName = null)
    {
        # 判断是否为通过Files上传的
        if(!isset($_FILES[$file])){
            throw new \Exception('要上传的文件不存在');
        }
        # 上传文件
        if(!$this->moveUploadedFile($file, $newFile)){
            throw new \Exception('文件上传失败');
        }
        # 获取新文件名
        if($newFile==null){
            $newFile = $this -> getARandLetter(15);
        }
        # 返回上传结果
        return $this->moveUploadedFile($_FILES[$file]['tmp_name'],$newName);
    }

    /**
     * 获取WebUrl
     * @return mixed
     */
    public function getWebUrl(){
        return $this -> webUrl;
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
