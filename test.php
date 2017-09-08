<?php
include './vendor/autoload.php';
use Itxiao6\Upload\Storage\FileSystem;
use Itxiao6\Upload\File;
use Itxiao6\Upload\Validation\Mimetype;
use Itxiao6\Upload\Validation\Size;

# 实例化文件存储系统
$storage = new FileSystem(__DIR__.'/data');

# 初始化文件上传系统
$file = new File('foo', $storage);



$new_filename = uniqid();
$file->setName($new_filename);


$file->addValidations(array(
    // Ensure file is of type "image/png"
    new Mimetype('image/png'),

    //You can also add multi mimetype validation
    //new \Upload\Validation\Mimetype(array('image/png', 'image/gif'))

    // Ensure file is no larger than 5M (use "B", "K", M", or "G")
    new Size('5M')
));

// 访问已上传文件
$data = array(
    'name'       => $file->getNameWithExtension(),
    'extension'  => $file->getExtension(),
    'mime'       => $file->getMimetype(),
    'size'       => $file->getSize(),
    'md5'        => $file->getMd5(),
    'dimensions' => $file->getDimensions()
);
// 尝试上传文件
try {
    // 成功!
    $file->upload();
} catch (\Exception $e) {
    // 失败!
    $errors = $file->getErrors();
}