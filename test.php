<?php
include './vendor/autoload.php';
use Itxiao6\Upload\Storage\FileSystem;
use Itxiao6\Upload\Storage\QiniuSystem;
use Itxiao6\Upload\File;
use Itxiao6\Upload\Validation\Mimetype;
use Itxiao6\Upload\Validation\Size;

# 模拟变量
$_FILES['picname'] = [
    'name'=>'WechatIMG8.jpeg',
    'type'=>'image/jpeg',
    'tmp_name'=>__DIR__.'/WechatIMG8.jpeg',
    'error'=>0,
    'size'=>filesize('WechatIMG8.jpeg'),
];


# 实例化文件存储系统
//$storage = new FileSystem(__DIR__.'/data','http://test/upload/');
# 实例化七牛云储存
//$storage = new QiniuSystem(
//    'hmkboM638pl8WJZjPpbbgY5Ld2j9Ma0_RsCUPezt',
//    '0R2oEqEqmaOZSkwHl52D4hDQxKAUQIpdvPSvt',
//    'upload2',
//    'http://ovy5w74522h.bkt.cloudd2n.com');
# 实例化阿里云Oss
$storage = new

# 初始化文件上传系统
$file = new File('picname', $storage);



$new_filename = uniqid();
$file->setName($new_filename);


$file->addValidations(array(
    // Ensure file is of type "image/png"
//    new Mimetype('image/png'),

    //You can also add multi mimetype validation
    //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

    // Ensure file is no larger than 5M (use "B", "K", M", or "G")
    new Size('5M')
));

// 尝试上传文件
try {
    // 成功!
    var_dump($file->upload());
} catch (\Exception $e) {
    // 失败!
    $errors = $file->getErrors();
}
# 获取Web url
var_dump($file->getWebUrl());
# 获取错误信息
var_dump($errors);