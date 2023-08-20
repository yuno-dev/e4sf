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

include("baglanti.php");

$ayarsor=$db->prepare("SELECT * FROM ayar where ayar_id = ?");
$ayarsor->execute(array(0));
$ayarcek=$ayarsor->fetch();

$site = "http";
    if(isset($_SERVER["HTTPS"])){
        if($_SERVER["HTTPS"] == "on"){
            $site .= "s";
        }
    }
    $site .= "://";
    $site .= $_SERVER["SERVER_NAME"];

$batihost_id = $ayarcek['batihost_id'];
$batihost_email = $ayarcek['batihost_mail'];
$batihost_token = $ayarcek['batihost_token'];

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
					<p>Kredi kartı ödemesiyle yüklenecek kredi miktarını belirlemek için aşağı kaydırın.</p>
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
                <div class="haberBaslikYazi">Kredi Yükleme</div>
                <div class="haberBaslikTarih">Kredi Kartı</div>
            </div>
            <div class="haberIcerik">
				<center>
				<p>Yüklemek istediğiniz kredi miktarını girin. (min. 1 / max. 200)</p></br>
                <form method="post" action="http://batigame.com/vipgateway/viprec.php">
								<input type="hidden" name="odemeturu" value="kredikarti">
								<input type='hidden' name='oyuncu' value="<?php echo $kullanici['username']; ?>">
								<input type="hidden" name="odemeolduurl" value="<?php echo $site; ?>/krediybasarili.php">
								<input type="hidden" name="odemeolmadiurl" value="<?php echo $site; ?>/krediybasarisiz.php">
								<input type="hidden" name="vipname" value="kredi">
								<input type="hidden" name="raporemail" value="<?php echo $batihost_email; ?>">
								<input type="hidden" name="posturl" value="<?php echo $site; ?>/batihost_kredi_post.php">
								<input type="hidden" name="batihostid" value="<?php echo $batihost_id;?>">
								<input type="number" style="width: 250px" min="1" max="200" class="form-control" name="amount" required="" placeholder="KREDİ MİKTARI" value="">
								<br></br>
								<button type="sumbit" class="btn btn-success"> Ödemeye geç </button>
								<br>
								</form>
				</center>
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