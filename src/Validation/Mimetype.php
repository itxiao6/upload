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
        '3gpp'=>'audio/3gpp, video/3gpp',
        'ac3'=>'audio/ac3',
        'asf'=>'allpication/vnd.ms-asf',
        'au'=>'audio/basic',
        'css'=>'text/css',
        'csv'=>'text/csv',
        'doc'=>'application/msword',
        'dot'=>'application/msword',
        'dtd'=>'application/xml-dtd',
        'dwg'=>'image/vnd.dwg',
        'dxf'=>'image/vnd.dxf',
        'gif'=>'image/gif',
        'htm'=>'text/html',
        'html'=>'text/html',
        'jp2'=>'image/jp2',
        'jpe'=>'image/jpeg',
        'jpeg'=>'image/jpeg',
        'jpg'=>'image/jpeg',
        'js'=>'text/javascript, application/javascript',
        'json'=>'application/json',
        'mp2'=>'audio/mpeg, video/mpeg',
        'mp3'=>'audio/mpeg',
        'mp4'=>'audio/mp4, video/mp4',
        'mpeg'=>'video/mpeg',
        'mpg'=>'video/mpeg',
        'mpp'=>'application/vnd.ms-project',
        'ogg'=>'application/ogg, audio/ogg',
        'pdf'=>'application/pdf',
        'png'=>'image/png',
        'pot'=>'application/vnd.ms-powerpoint',
        'pps'=>'application/vnd.ms-powerpoint',
        'ppt'=>'application/vnd.ms-powerpoint',
        'rtf'=>'application/rtf, text/rtf',
        'svf'=>'image/vnd.svf',
        'tif'=>'image/tiff',
        'tiff'=>'image/tiff',
        'txt'=>'text/plain',
        'wdb'=>'application/vnd.ms-works',
        'wps'=>'application/vnd.ms-works',
        'xhtml'=>'application/xhtml+xml',
        'xlc'=>'application/vnd.ms-excel',
        'xlm'=>'application/vnd.ms-excel',
        'xls'=>'application/vnd.ms-excel',
        'xlt'=>'application/vnd.ms-excel',
        'xlw'=>'application/vnd.ms-excel',
        'xml'=>'text/xml, application/xml',
        'zip'=>'aplication/zip',
        'xlsx'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'php' => 'text/html',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

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
