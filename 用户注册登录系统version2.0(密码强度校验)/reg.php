

<?php
if(!isset($_POST['submit'])){
	exit('非法访问!');
}
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
//注册信息判断
//Email地址：^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$

if(!preg_match('/^[\w\x80-\xff]{3,}$/', $username)){
	exit('错误：用户名不符合规定。< a href="javascript:history.back(-1);">返回</ a>');
}
if(strlen($password) > 36){
	exit('错误：密码长度不符合规定。< a href="javascript:history.back(-1);">返回</ a>');
}
if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email)){
	exit('错误：电子邮箱格式错误。< a href="javascript:history.back(-1);">返回</ a>');
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
     exit('错误：密码强度过低,请重新注册.<a href="javascript:history.back(-1);">返回</ a>');

}

//包含数据库连接文件
include('conn.php');
//检测用户名是否已经存在
$check_query = mysqli_query($conn,"select uid from user where username='$username' limit 1");
 
if(mysqli_fetch_array($check_query)){
	echo '错误：用户名 ',$username,' 已存在。<a href="javascript:history.back(-1);">返回</a>';
	exit;
}


//写入数据

$password = MD5($password);

$regdate = time();

//print($regdate);

$sql = " INSERT INTO user(username,password,email,regdate)VALUES('$username','$password','$email','$regdate')";





if(mysqli_query($conn,$sql)){
         exit('用户注册成功！点击此处 <a href="login.html">登录</a>');
} else {
        echo '抱歉！添加数据失败：',mysqli_error($conn),'<br />';
        echo '点击此处 <a href="javascript:history.back(-1);">返回</a> 重试';
}


?>


