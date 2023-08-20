<?php 

session_start(); //session işlemini başlatıyoruz.
if(!isset($_SESSION['user_nick']))//session varmı die kontrol ediyoruz. yok ise buraya giricek
{
	header("Location:girisyap.php");//eğer session yok ise bizi giris.php gönderecek.
}
?>
<?php
include("baglanti.php");
include("meta.php");
error_reporting(0);
session_start();
ob_start();

$ayarsor=$db->prepare("SELECT * FROM ayar where ayar_id = ?");
$ayarsor->execute(array(0));
$ayarcek=$ayarsor->fetch();

$kullanicisor = $db->prepare("select * from authme where username=:username");
$kullanicisor->execute(array('username' => $_SESSION['user_nick']));

$kullanici = $kullanicisor->fetch(PDO::FETCH_ASSOC);
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
					<p>Profilinizi görmek için sayfayı aşağı kaydırın.</p>
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
            <div class="haberBaslik">
                <div class="haberBaslikYazi">Profilim</div>
                <a href="sifredegistir.php"><div class="haberBaslikTarih">Şifre Değiştir</div></a>
            </div>
            <div class="haberIcerik">


			<table id="example2" class="table table-bordered table-hover">
                <thead>

                <tr>
				  <th><center>Profil Fotoğrafı</center></th>
                  <th><center>Kullanıcı adı</center></th>
                  <th><center>Kredi</center></th>
				  <th><center>Yetki</center></th>
                </tr>

                </thead>
                <tbody>

                
                <tr>
				  <td><center><img src="https://minotar.net/cube/<?php echo $_SESSION['user_nick']; ?>/100.png"></center></td>
                  <td><center><h2><?php echo $_SESSION['user_nick']; ?></h2></center></td>
                  <td><center><h2><?php echo $kullanici['kredi']; ?><a href="krediyukle.php"><span style="color: #F44A40;">+</span></a></h2></center></td>
				  <td><center><h2><?php if ($kullanici['yetki']==0) {?>Üye<?php } ?><?php if ($kullanici['yetki']==2) {?>Cezalı<?php } ?><?php if ($kullanici['yetki']==1) {?>Admin<?php } ?></h2></center></td>
                </tr>

            	
                </tbody>
              </table>
				</br></br>
				
				
				</div>
            <div class="cizgi"></div>
					<!------------
					--------------
					-------------->
					<div class="highlights">
					</div>
				</div>
			</section>

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