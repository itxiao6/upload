<?php

# 文件上传示例

include "./vendor/autoload.php";

# 引入入口
use Itxiao6\Upload\Upload;

# 本地存储器

//# 设置文件存储驱动
//Upload::set_driver('Local');
//
//# 定义上传的文件夹
//$directory = __DIR__.'/';
//
//# 定义上传完的webUrl
//$webUrl = '/';
//
//# 启动上传组件
//Upload::start($directory,$webUrl);


# 七牛云存储器
# 设置文件存储驱动
Upload::set_driver('Qiniu');

# 定义accessKey
$accessKey = 'hmkboM638pl8WJZjPpbbgY5Ldzj9Ma0_RsCUPezt';
# 定义secretKey
$secretKey = '0R2oEqEqmaOZSkwHl5aSXYD4hDQxKAUQIpdvPSvt';
# 定义桶的名字
$Bucket_Name = 'upload';

# 定义外网访问路径
$host = 'http://ovy5w745h.bkt.clouddn.com/';

# 启动上传组件
Upload::start($accessKey,$secretKey,$Bucket_Name,$host);




# 上传文件
$data = Upload::upload('image');

# 判断是否上传成功
if($data!=false){
    # 输出图片
    echo "<img src='".$data."'>";
}else{
    # 输出错误信息
    echo Upload::get_error_message();
}

