<?php
header("Access-Control-Allow-Origin:*");
//*表示所有域都接受
//在页头使用date_default_timezone_set()设置我的默认时区为北京时间
date_default_timezone_set('PRC');

//真实路径
$upload_dir='';
//域名路径（用于访问）
$cupload='';
$up_dir = $_SERVER['DOCUMENT_ROOT'];//首先获取当前文件的根目录

//存放路径加时间便于管理
$cupload='路径'.date('Ymd',time())."/";
$upload_dir=$up_dir.'路径'.date('Ymd',time())."/";


//检查是否存在，不存在创建
if(!file_exists($upload_dir)){
	mkdir($upload_dir, 0700,true);
}



//文件处理


$error=$_FILES['file']['error'];
//文件名字
$name=$_FILES['file']['name'];
$type=$_FILES['file']['type'];
$size=$_FILES['file']['size'];
//临时路劲
$tmp_name=$_FILES['file']['tmp_name'];

$info='';


//取后缀
$arr=explode('.',$name);
$end=end($arr);//取数组最后一个

//拼接名字
$time=time();
$filename=$upload_dir.'_'.date('His',time()).'.'.$end;
$cfilename='域名'.$cupload.('His',time()).'.'.$end;
if (move_uploaded_file($tmp_name, $filename)){
	//返回带域名的地址
	return $cfilename;
	
}else{
	return '上传失败';
}




