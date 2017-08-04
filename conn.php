<?php
/*****************************
*数据库连接
*****************************/

$dbh = new PDO('mysql:host=localhost;dbname=2017summer', "root", "m");


if (!$dbh){
	die("连接数据库失败：" . mysqli_error());
}
/*else{
   echo "连接数据库成功!";
}*/
?>
