<?php
session_start();
if(!$_SESSION['userid']){
	echo '<script type="text/javascript">alert("非法访问!请先登录~");</script>';

	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
}

$file_name = $_GET['filename'];//url中包含的md5值


$dir="uploads/";
if (false != ($handle = opendir ( $dir ))) {
    while (false !== ($file = readdir($handle))) {
            $m_file="uploads/".$file;
            $fn=md5_file($m_file);
            if($fn==$file_name){
              $file_name=$file;
            }
    }
    closedir($handle);
}

header("Content-type:text/html;charset=utf-8");
//$file_name = $_GET['filename'];
//用以解决中文不能显示出来的问题
//$file_name=iconv("utf-8","gb2312",$file_name);
//$file_sub_path=$_SERVER['DOCUMENT_ROOT']."marcofly/phpstudy/down/down/";
$file_path='uploads/'.$file_name;


$fp=fopen($file_path,"r");
$file_size=filesize($file_path);
//下载文件需要用到的头
Header("Content-type: application/octet-stream");
Header("Accept-Ranges: bytes");
Header("Accept-Length:".$file_size);
Header("Content-Disposition: attachment; filename=".$file_name);
$buffer=1024;
$file_count=0;
//向浏览器返回数据
while(!feof($fp) && $file_count<$file_size){
$file_con=fread($fp,$buffer);
$file_count+=$buffer;
echo $file_con;
}
fclose($fp);

?>
