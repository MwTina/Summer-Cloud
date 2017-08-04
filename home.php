<?php
session_start();
if(!$_SESSION['userid']){
	echo '<script type="text/javascript">alert("非法访问!请先登录~");</script>';

	$url = "start.html";
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='$url'";
	echo "</script>";
}
?>

<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Home</title>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/icomoon.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/modernizr-2.6.2.min.js"></script>

	</head>
	<body>

	<div class="gtco-loader"></div>
	<div id="page">

	<div class="page-inner">
	<nav class="gtco-nav" role="navigation">
		<div class="gtco-container">

				<div class="col-xs-15 text-right menu-1">
					<ul>
						<li><a href="home.php">Home</a></li>
						<li><a href="share.html">Share</a></li>
						<li class="btn-cta"><a href="login.php?action=logout"><span>Log out</span></a></li>
					</ul>
				</div>

		</div>
	</nav>

	<header id="gtco-header" class="gtco-cover gtco-cover-sm" role="banner" style="background-image: url(images/img_4.jpg)">
		<div class="overlay"></div>
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12 col-md-offset-0 text-left">
					<div class="row row-mt-15em">

						<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
							<span class="intro-text-small">2017 summer</span>
							<h1>My File Cloud</h1>
						</div>

					</div>

				</div>
			</div>
		</div>
	</header>


	<div class="gtco-section border-bottom">
		<div class="gtco-container">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6 animate-box">
					<h3>Upload</h3>

					<form enctype="multipart/form-data" action="upload.php" method="POST">
						<div class="row form-group">
							<div class="col-md-12">
								<!-- MAX_FILE_SIZE must precede the file input field -->
								<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
								<!-- Name of input element determines name in $_FILES array -->
								Send this file: <input name="file" type="file" />
							</div>
						</div>

						<div class="form-group">
							<input type="submit" value="Send File" class="btn btn-primary">
						</div>

					</form>
				</div>
				<div class="col-md-5 col-md-push-1 animate-box">

					<div class="gtco-contact-info">
						<h3>Download</h3>
						<h3>my file list</h3>
						<ul>
							<li class="url"><a href="http://">
<?php

								$dir="uploads/";
								//$dir="/var/www/html/uploads"; //指定的路径
								//$sitepath = 'http://localhost/ftp/';
								//遍历文件夹下所有文件
								if (false != ($handle = opendir ( $dir ))) {
								    //$i = 0;
								    while (false !== ($file = readdir($handle))) {
								        if ($file != "." && $file != ".." && !is_dir($dir.'/'.$file)) {
								            //echo '<a href="download.php">'.$file. '</a>';
														$m_file="uploads/".$file;
														$fn=md5_file($m_file);
														echo '<a href="download.php?filename='.$fn.'">';
														echo $file;
								            echo "<br />\n";

								        }
								    }
								    //关闭句柄' . $sitepath . $file . '
								    closedir($handle);
								}

								?>

							</a></li>
						</ul>
					</div>


				</div>
				</div>
			</div>
		</div>
	</div>


	</div>

	</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.countTo.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>
	<script src="js/main.js"></script>


	</body>
</html>
