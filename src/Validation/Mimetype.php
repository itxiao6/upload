<?php
namespace Itxiao6\Upload\Validation;
/**
 * 文件类型验证
 * Class Mimetype
 * @package Itxiao6\Upload\Validation
 */
class Mimetype implements Base
{
    /**
     * 错误信息
     * @var null | string
     */
    protected $Message = null;
    /**
     * 允许的文件类型
     * @var null | array
     */
    protected $AllowType = null;
    /**
     * 文件类型
     * @var null | string
     */
    protected $FileType = null;

    /**
     * 文件类型列表
     * @var array
     */
    protected $FileTypeList = [
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    ];
    /**
     * 构造方法
     * Mimetype constructor.
     * @param $AllowType 允许上传的文件类型
     */
    public function __construct($AllowType)
    {
        $this -> AllowType = $AllowType;
    }

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
     */
    public function validation($file)
    {
        # 获取文件类型
        $this -> FileType = mime_content_type($file['tmp_name']);
        # 判断是否设置了允许的文件类型
        if($this -> AllowType == null){
            $this -> AllowType = $this -> FileTypeList;
        }
        # 判断文件类型是否存在于允许的列表
        if(isset($this -> AllowType[$this -> FileType]) && in_array($this -> FileType,$this -> AllowType)){
            return true;
        }else{
            $this -> Message = '文件类型不被允许上传';
            return false;
        }
    }
}
