

<?php
/*****************************
*数据库连接
*****************************/

$conn =mysqli_connect("localhost","root","9027yj");


if (!$conn){
	die("连接数据库失败：" . mysqli_error());
}
/*
else{
   echo "连接数据库成功!";
}
*/

//mysqli_close($conn);


mysqli_select_db( $conn,"test1" );
//字符转换，读库


mysqli_set_charset($conn, "gbk");

/*
if (!mysqli_set_charset($conn, "gbk")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($conn));
} else {
    printf("Current character set: %s\n", mysqli_character_set_name($conn));
}
*/

?>





