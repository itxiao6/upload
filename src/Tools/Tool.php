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