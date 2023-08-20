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

<?php

include("ayar.php");
$baslik=$_POST['baslik'];
$icerik=$_POST['icerik'];
$kategori=$_POST['kategori'];
$kanit=$_POST['kanit'];
$ipadres = $_SERVER['REMOTE_ADDR'];
$guncelleme = date('YmdHis');
$durum = "0";

if($baslik == "" || $kategori == "" || $icerik == ""){
    
}
else{
        $ticket_olustur = $db->prepare("INSERT INTO tickets (nick,baslik,kategori,mesaj,durum,son_guncelleme,kanit) VALUES(?,?,?,?,?,?,?)");
        $ticket_olustur->execute(array($_SESSION["user_nick"],strip_tags($baslik),strip_tags($kategori),strip_tags($icerik),strip_tags($durum),strip_tags($guncelleme),strip_tags($kanit)));
        echo "<script>alert('Talebiniz gönderildi. En yakın zamanda cevap verilecektir.');</script>";
        header("location:dst.php");
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
					<p>Destek talebi oluşturmak için sayfayı aşağı kaydırın.</p>
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
                <div class="haberBaslikYazi">Destek Talepleri > Talep Oluştur</div>
                <a href="dst-olustur.php"><div class="haberBaslikTarih"><-- Geri Dön</div></a>
            </div>
            <div class="haberIcerik">
            	<form action="" method="POST">
Başlık: *

<input required type="text" id="baslik" name="baslik" maxlength="70" style="width: 100%" placeholder="Bir Başlık Belirleyiniz." />

Konu: *
   <select name="kategori" id="kategori" style="width: 101%">
       <option value="Genel">Genel</option>
       <option value="Öneri">Öneri</option>
       <option value="Şikayet">Şikayet</option>
       <option value="Hile Bildirimi">Hile Bildirimi</option>
       <option value="Ödeme Bildirimi">Ödeme Bildirimi</option>
       <option value="Diger islemler">Diğer işlemler</option>
   </select>

Kanıt URL:
<input type="text" id="kanit" name="kanit" style="width: 100%;" placeholder="Resim veya video bağlantı adresini girin." />

<font face="Roboto Condensed" size="4"> Mesajınız: *</font>
<textarea style="width: 100%; height: 120px;" required type="text" id="icerik" name="icerik"placeholder="Destek ekibimize iletmek istediğiniz mesajı yazın."></textarea>

<button type="submit" name="destekAc">Gönder</button>
                    </table>
                </form>
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