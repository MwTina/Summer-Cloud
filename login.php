<?php
session_start();

//注销登录
if($_GET['action'] == "logout"){
	unset($_SESSION['userid']);
	unset($_SESSION['username']);
	unset($_SESSION['password']);

	echo '<script type="text/javascript">alert("注销成功");</script>';
	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
}


//登录
if(!isset($_POST['submit'])){
	echo '<script type="text/javascript">alert("非法访问!");</script>';

	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
}


$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];

//包含数据库连接文件
include('conn.php');
//检测用户名及密码是否正确
$check_query = $dbh->query("select * from user where username='$username' ");
$result = $check_query->fetch(PDO::FETCH_ASSOC);

if(password_verify($_POST['password'],$result['password'])){
	//登录成功
	$_SESSION['username'] = $username;
	$_SESSION['userid'] = $result['uid'];
	$_SESSION['password'] = $password;

	$url = "home.php";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
	exit;
}

else {
	echo '<script type="text/javascript">alert("用户名或密码错误!请重新登录");</script>';

	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
}
?>
