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

$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

?>

<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<base href="<?php echo $config['base_url']; ?>">
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
					<p>Destek talebinizi görmek ve mesaj yazmak için sayfayı aşağı kaydırın.</p>
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
                <div class="haberBaslikYazi">Destek Talepleri > Talep Göster</div>
                <a href="dst.php"><div class="haberBaslikTarih"><-- Geri Dön</div></a>
            </div>
            <div class="haberIcerik">

            	<center>
            		<?php
		
						$ticket_kontrol = $db->prepare("SELECT * FROM tickets WHERE id = ? and nick = ?");
						$ticket_kontrol->execute(array($_GET["id"],$_SESSION['user_nick']));	
						$ticket_oku = $ticket_kontrol->fetch();	
							if($ticket_kontrol->rowCount() != 0){
					?>
            		<h2>Siz:</h2>
            		<p><?php echo $ticket_oku["mesaj"]; ?></p>
            		<br>
            		<?php
							if($ticket_oku["cevap"] != NULL){
						?>
						<h2>Cevap:</h2>
					<p><?php echo $ticket_oku["cevap"]; ?></p>
            	<?php } ?>
            	<?php
							$tickets_sc = $db->prepare("SELECT * FROM tickets_sc WHERE nick = ? and ticket_id = ?");
							$tickets_sc->execute(array($_SESSION['user_nick'],$_GET["id"]));

							if($tickets_sc->rowCount() != 0){

								foreach ($tickets_sc as $tickets_sc_oku) {

									if($tickets_sc_oku["soru"] != NULL){
						?>
					<h2>Siz:</h2>
            		<p><?php echo $tickets_sc_oku["soru"]; ?></p>
            		<br>
            		<?php 
								
								}
							if($tickets_sc_oku["cevap"] != NULL){
						?>
						<h2>Cevap:</h2>
						<p><?php echo $tickets_sc_oku["cevap"]; ?></p>
					<?php } ?>

					<?php
								}
							}
						}

						?>
						<?php

if($ticket_oku["durum"] != 3){

if(isset($_POST['soru_gonder'])){
$soru 		= strip_tags($_POST['soru']);
$durum 		= "2";
$guncelleme = date('YmdHis');

if($_POST["soru"] == ""){
	echo '
             <h2 style="color:red">Boş alan bırakmayın!</h2>
	';
}
else{
		$cevap_gonder = $db->prepare("INSERT INTO tickets_sc (nick,ticket_id,soru) VALUES(?,?,?)");
		$cevap_gonder->execute(array($_SESSION['user_nick'],$_GET["id"],$soru));

		$durum_guncelle =  $db->prepare("UPDATE tickets SET durum = ?, son_guncelleme = ? WHERE nick = ? and id = ?");
		$durum_guncelle->execute(array($durum,$guncelleme,$_SESSION['user_nick'],$_GET["id"]));

		echo '<meta http-equiv="refresh" content="0;URL=dst-goster.php?id='.$_GET["id"].'">';
}
}
}
?>
<form action="" method="post">
<textarea required name="soru" placeholder="Destek ekibimize bırakmak istediğiniz mesajı yazınız." rows="5"></textarea>
<br>
<button name="soru_gonder" type="submit">Gönder</button>
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