<?php

	include("baglanti.php");
	include("meta.php");
	error_reporting(0);
	session_start();
	ob_start();
	
if(!isset($_SESSION['user_nick']))
{
echo str_repeat("<br>", 8)."<center><h2>Bu sayfayı görebilmek için giriş yapman lazım!</center>";
echo '<meta http-equiv="refresh" content="2;URL=/girisyap.php">';
return;
}
?>

<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title><?php echo $ayarcek['site_title']; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="<?php echo $descri ?>" />
		<meta name="keywords" content="<?php echo $keyword ?>" />
		<link rel="stylesheet" href="yenitema/assets/css/main.css" />
		<link rel="stylesheet" href="css/haber.css" />
	</head>
	<body class="is-preload">

		<!-- Header -->
			<header id="header">
				<a class="logo" href="index.php"><?php echo $ayarcek['sunucu_isim']; ?></a>
				<nav>
					<a href="#menu">Menü</a>
				</nav>
			</header>

		<!-- Nav -->
			<?php include('menu.php'); ?>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h1><?php echo $ayarcek['sunucu_isim']; ?></h1>
					<p><?php echo $ayarcek['sunucu_ip']; ?></p>
				</div>
			</section>

		<!-- Highlights -->
			<section class="wrapper">
				<div class="inner">
					<header class="special">
					</header>
					<!-------------
					--------------
					------------->
			<center>
			<?php 	
		if(isset($_POST['sifredegis'])){

		$kadi = htmlspecialchars($_POST["kadi"]);
		$epass=$_POST["esifre"];
		$ypass = $_POST["ysifre"];
		$ypass2 = $_POST["ysifre2"];
		$e_password=md5($epass);
		$kullanicisor=$db->prepare("select * from authme where password=:password");
		$kullanicisor->execute(array('password' => $e_password));
		$say=$kullanicisor->rowCount();
		if($say==0)
		{
			echo "<script>alert('Eski şifre yanlış')</script>";
		}
		else
		{
			if($ypass != $ypass2)
			{
				echo "<script>alert('Şifreler uyuşmuyor')</script>";
			}
			else
			{
				if(strlen($ypass)<=3)
				{
					echo "<script>alert('Şifreniz 4karakterden uzun olmalıdır.')</script>";
				}
				else
				{
					$sifre = md5($ypass);
					$kullanicikaydet=$db->prepare("UPDATE authme SET password=:password WHERE username=:username");

				
					$insert=$kullanicikaydet->execute(array(
						'password' => $sifre, 'username' => $_SESSION['user_nick']));
					if($insert){
						session_destroy();
						echo "<script>alert('Başarıyla şifre değiştirldi, şifreniz değiştirldiği için çıkış yapıldı.')</script>";
						echo '<meta http-equiv="refresh" content="2;URL=/index.php">';
					}
					else
					{
						echo "<script>alert('Şifreniz değiştirilemedi')</script>";
					}
				}
			}
		}
	} ?>
			<form method="post" action="">
			<br>
			<strong>Kullanıcı adın: <?php echo $_SESSION['user_nick']; ?></strong>
			<br><br>
			<strong>Eski şifre</strong> 
			<br>
			<input type="password" minlength="4" maxlength="16" type="text" name="esifre" />
			<br><br>
			<strong>Yeni Şifre</strong> 
			<br>
			<input type="password" minlength="4" maxlength="16" type="text" name="ysifre" />
			<br><br>
			<strong>Yeni Şifre Tekrar</strong>
			<br>
			<input type="password" minlength="4" maxlength="16" type="text" name="ysifre2" />
			<br>
			<input type="submit" name="sifredegis" value="Tıkla, şifre değiştir" style="margin-top: 15px">
			<br><br>
			</form>
		</div>
			</center>

		<!-- Footer -->
			<?php
			include("foot.php");
			?>

		<!-- Scripts -->
			<script src="yenitema/assets/js/jquery.min.js"></script>
			<script src="yenitema/assets/js/browser.min.js"></script>
			<script src="yenitema/assets/js/breakpoints.min.js"></script>
			<script src="yenitema/assets/js/util.js"></script>
			<script src="yenitema/assets/js/main.js"></script>

	</body>
</html>