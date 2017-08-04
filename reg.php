<?php

if(!isset($_POST['submit'])){
	echo '<script type="text/javascript">alert("非法访问!");</script>';

	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
}

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];


if(!preg_match('/^[\w\x80-\xff]{3,}$/', $username)){
	echo '<script type="text/javascript">alert("错误：用户名不符合规定!");</script>';

	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
}

if(strlen($password) > 36){
	echo '<script type="text/javascript">alert("错误：密码长度不符合规定!");</script>';

	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
}

if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email)){
	echo '<script type="text/javascript">alert("错误：电子邮箱格式错误!");</script>';

	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
}



//对用户输入的口令进行强度校验，禁止使用弱口令
//* 表示对前面原子的数量控制，表示是任意次，等价于{0,}
//.  表示任意一个除换行符之外的字符
function testPasswordsre($password)
{
  $tag = 0;

 if(preg_match('/(?=.{6,}).*/',$password)==0)//至少6个字符
  {
    $tag = 1;
  }
  else if(preg_match('/^((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|(?=.{6,})(((?=.*[A-Z])(?=.*[a-z]))).*$/',$password))//大小写字母和数字两两组合 或 三者组合
  {
    $tag = 2;
  }
  else {
    $tag = 1;
  }
   return $tag;
}

$tag=testPasswordsre($password);
if($tag ==0 || $tag==1)
{
		 echo '<script type="text/javascript">alert("错误：密码强度过低,请重新注册!");</script>';

		 $url = "start.html";
		 echo "<script language='javascript' type='text/javascript'>";
		 echo "window.location.href='$url'";
		 echo "</script>";
}


//包含数据库连接文件
include('conn.php');

//检测用户名是否已经存在
$check_query = $dbh->query("select uid from user where username='$username' ");
$row= $check_query->fetch(PDO::FETCH_ASSOC);
if($row['uid']){
	echo '<script type="text/javascript">alert("错误：用户名已存在!");</script>';

	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";

}

else{

	//写入数据
	//$password = password_hash($password,PASSWORD_BCRYPT);
  $password = password_hash($password, PASSWORD_BCRYPT);
	
	$stmt = $dbh->prepare ("INSERT INTO user (username,password,email) VALUES (:username,:password,:email)");

	$stmt -> bindParam(':username', $username);
	$stmt -> bindParam(':password', $password);
	$stmt -> bindParam(':email', $email);

	//$stmt -> execute();

	//if($stmt->execute()){echo "okokokok!!!";}

	if($stmt->execute()){
		echo '<script type="text/javascript">alert("注册成功！请先登录~");</script>';

		$url = "start.html";
		echo "<script language='javascript' type='text/javascript'>";
		echo "window.location.href='$url'";
		echo "</script>";
	}

	else {
		echo '抱歉！添加数据失败：',mysqli_error($conn),'<br />';
		/*echo '<script type="text/javascript">alert("抱歉，添加数据失败!");</script>';

		$url = "start.html";
		echo "<script language='javascript' type='text/javascript'>";
		echo "window.location.href='$url'";
		echo "</script>";*/
	}

}

?>
