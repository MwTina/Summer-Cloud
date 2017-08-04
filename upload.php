<?php
session_start();
//echo "uploaded seccessfully !";

 //print_r($_FILES);
 // 取得上传文件信息
    $fileName = $_FILES['file']['name'];
    $fileType = $_FILES['file']['type'];
    $fileError = $_FILES['file']['error'];
    $fileSize = $_FILES['file']['size'];
    $tempName = $_FILES['file']['tmp_name'];



//  加密上传文件
    $handle = fopen($tempName, "r+");
    /*if($handle)
     {  echo "OK open";}
     else{  echo "fail open";}*/


    $input1 = fread($handle, filesize($tempName));
    //print($input1);

    if(!function_exists("hex2bin")) { // PHP 5.4起引入的hex2bin
    function hex2bin($data) {
        return pack("H*", $data);
       }
    }


// ECB模式加密用不到IV，CBC模式才会用到IV
// 所以IV不管如何随机变化，ECB模式下完全不受IV变化的影响，固定明文输入，确定密文输出
function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}

mt_srand(make_seed());
$randval = mt_rand();

$td = mcrypt_module_open('tripledes', '', 'cbc', '');
$block_size = mcrypt_enc_get_block_size($td);
$iv1 = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);

//var_dump(bin2hex($iv));
mcrypt_generic_init($td, $randval, $iv1);
$encrypted_data1 = mcrypt_generic($td, $input1);

mcrypt_generic_deinit($td);
mcrypt_module_close($td);

$key = $_SESSION['password'];//获取的用户口令
$td1 = mcrypt_module_open('tripledes', '', 'cbc', '');
$block_size = mcrypt_enc_get_block_size($td1);
$iv2 = mcrypt_create_iv(mcrypt_enc_get_iv_size($td1), $key);

mcrypt_generic_init($td1, $key, $iv2);
$encrypted_data2 = mcrypt_generic($td1,$randval );

mcrypt_generic_deinit($td1);
mcrypt_module_close($td1);


//print_r(bin2hex($encrypted_data1)."<br />\n");
//print_r(bin2hex($encrypted_data2)."<br />\n");

fclose($handle);

$handle1 = fopen($tempName, "w");

fwrite($handle1,bin2hex($encrypted_data1.$encrypted_data2));

//fwrite($handle1,"123");
fclose($handle1);


 // 定义上传文件类型
    $typeList = array("image/jpeg", "image/jpg", "image/png", "image/gif","text/plain","application/msword");//定义允许的类型
    if ($fileError > 0) {
            // 上传文件错误编号判断
            switch ($fileError) {
                case 1:
                    $message = "上传的文件超过了php.ini 中 upload_max_filesize 选项限制的值。";
                    break;
                case 2:
                    $message = "上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。";
                    break;
                case 3:
                    $message = "文件只有部分被上传。";
                    break;
                case 4:
                    $message = "没有文件被上传。";
                    break;
                case 6:
                    $message = "找不到临时文件夹。";
                    break;
                case 7:
                    $message = "文件写入失败";
                    break;
            }
            exit("文件上传失败：".$message);
    }


    if (is_uploaded_file($tempName)) {
        //echo "File ". $tempName ." uploaded successfully.\n";

    }else
     {
         echo '<script type="text/javascript">alert("Possible file upload attack");</script>';

         $url = "home.php";
         echo "<script language='javascript' type='text/javascript'>";
         echo "window.location.href='$url'";
         echo "</script>";

     }
    if (!in_array($fileType, $typeList)) {
        echo '<script type="text/javascript">alert("上传的文件不是指定类型");</script>';

        $url = "home.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
   }
    if ($fileSize > 1048576) {
        echo '<script type="text/javascript">alert("上传文件超出限制大小");</script>';

        $url = "home.php";
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.location.href='$url'";
        echo "</script>";
    } else {
        //避免上传文件的中文名乱码
        //$fileName = iconv("UTF-8", "GBK", $fileName);// 把iconv抓取到的字符编码从utf-8转为gbk输出

        if (move_uploaded_file($tempName, "uploads/".$fileName)) {
            echo '<script type="text/javascript">alert("上传成功");</script>';

            $url = "home.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";

        } else {
            echo '<script type="text/javascript">alert("上传失败");</script>';

            $url = "home.php";
            echo "<script language='javascript' type='text/javascript'>";
            echo "window.location.href='$url'";
            echo "</script>";
        }
    }

?>
