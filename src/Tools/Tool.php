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