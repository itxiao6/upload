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
     * base字符转 文件
     */
    public static function base64_to_file($file)
    {
        # 匹配文件内容
        preg_match('!data:(.*?);base64,!',$file,$arr);
        # 获取文件MIME类型
        $file_type = $arr[1];
        # 获取文件内容
        $content = explode(',',$file)[1];
        # 获取随机文件名
        $file_name = self::getARandLetter(15);
        # 解码为二进制
        $tmp_name = [];
        # 获取临时文件名
        $tmp_name['tmp_name'] = ini_get("upload_tmp_dir").DIRECTORY_SEPARATOR.self::getARandLetter(15);
        # 写入文件 并获取文件大小
        $tmp_name['size'] = file_put_contents($tmp_name['tmp_name'],base64_decode($content));
        # 文件类型
        $tmp_name['type'] = $arr[1];
        # 判断上传是否成功
        if($tmp_name['size'] > 0){
            $tmp_name['error'] = 0;
        }
        # 获取文件名
        $tmp_name['name'] = $file_name;
        # 获取临时字段名
        $name = self::getARandLetter(5);
        # 累加到FILES
        $_FILES[$name] = $tmp_name;
        # 返回临时字段
        return $name;
    }
    /**
     * 获取指定长度的随机字符串
     * @param $num
     * @return string
     */
    public static function getARandLetter($num){
        $str = '';
        for ($i=0;$i<=$num;$i++){
            $str .= rand(0,555);
        }
        return $str;
    }

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