<?php
namespace Itxiao6\Upload\Tools;

/**
 * 上传工具包
 * Class Tool
 * @package Itxiao6\Upload\Tools
 */
class Tool
{
    /**
     * 文件MIME类型
     * @var array
     */
    protected static $file_type = [
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
    ];
    /**
     * 上传的多个文件转成多条
     */
    public static function files_to_item($name = null)
    {
        for ($i=0;$i<count($_FILES[$name]['name']);$i++){
            yield [
                'name'=>$_FILES[$name]['name'][$i],
                'type'=>$_FILES[$name]['type'][$i],
                'tmp_name'=>$_FILES[$name]['tmp_name'][$i],
                'error'=>$_FILES[$name]['error'][$i],
                'size'=>$_FILES[$name]['size'][$i],
            ];
        }
    }
}