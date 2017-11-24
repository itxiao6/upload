<?php

# 文件上传示例

include "../vendor/autoload.php";

# 引入入口
use Itxiao6\Upload\Upload;

# 本地存储器

# 设置文件存储驱动
Upload::set_driver('Local');

# 定义上传的文件夹
$directory = __DIR__.'/';

# 定义上传完的webUrl
$webUrl = '/';

# 启动上传组件
Upload::start($directory,$webUrl);


# 七牛云存储器
# 设置文件存储驱动
//Upload::set_driver('Qiniu');

//# 定义accessKey
//$accessKey = 'hmkboM638pl8WJZjPpbbgY5Ldzj9Ma0_RsCUPezt';
//# 定义secretKey
//$secretKey = '0R2oEqEqmaOZSkwHl5aSXYD4hDQxKAUQIpdvPSvt';
//# 定义桶的名字
//$Bucket_Name = 'upload';
//
//# 定义外网访问路径
//$host = 'http://ovy5w745h.bkt.clouddn.com/';
//
//# 启动上传组件
//Upload::start($accessKey,$secretKey,$Bucket_Name,$host);
//# 获取七牛云的上传token
//$token = Upload::get_token();

//# 阿里云OSS存储器
//Upload::set_driver('Alioss');
//// 桶的名字
//$bucket_name = 'testupload';
//# 您选定的OSS数据中心访问域名 参考(https://help.aliyun.com/document_detail/31837.html?spm=5176.doc32100.2.4.QQpTvt)
//$data_host = 'oss-cn-hongkong.aliyuncs.com';
//# 阿里云的secretKey
//$accessKey = 'LTAIGsss9VH9407aZ';
//# 阿里云的secretKey
//$secretKey = 'UcKYz7ylVWGkasdaWsaWWs0wf3a';
//
//Upload::start($accessKey,$secretKey,$bucket_name,$data_host);
# 上传文件
//$data = Upload::uploads('image');
# 上传base64 文件
$data = Upload::upload_base64($_POST['file']);
# 判断是否上传成功
if($data!=false){
    # 输出图片
    echo "<img src='".$data."'>";
}else{
    # 输出错误信息
    echo Upload::get_error_message();
}

