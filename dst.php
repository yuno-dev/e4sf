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
					<p>Destek talepleriniz için sayfayı aşağı kaydırın.</p>
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
                <div class="haberBaslikYazi">Destek Talepleri</div>
                <a href="dst-olustur.php"><div class="haberBaslikTarih">Yeni Destek Talebi Oluştur +</div></a>
            </div>
            <div class="haberIcerik">


			<table id="example2" class="table table-bordered table-hover">
                <thead>

                <tr>
				  <th><center>Tarih</center></th>
                  <th><center>Başlık</center></th>
				  <th><center>Durum</center></th>
				  <th><center>İşlemler</center></th>
                </tr>

                </thead>
                </table>

                <?php

					$ticket_ogren = $db->prepare("SELECT * FROM tickets WHERE nick = ? ORDER BY son_guncelleme DESC LIMIT 10");
					$ticket_ogren->execute(array($_SESSION['user_nick']));		
						if($ticket_ogren->rowCount() != 0){

							foreach ($ticket_ogren as $ticket_cek) {

                        $saat= substr($ticket_cek['son_guncelleme'], 8, 2);
                        $dk= substr($ticket_cek['son_guncelleme'], 10, 2);
                        $gun= substr($ticket_cek['son_guncelleme'], 6, 2);
                        $ay= substr($ticket_cek['son_guncelleme'], 4, 2);
                        $yil= substr($ticket_cek['son_guncelleme'], 0, 4);

					?>

                <table class="table table-bordered table-hover">
                <tbody>
                <tr>
				  <td><center><?php echo ''.$gun.'.'.$ay.'.'.$yil.' '.$saat.':'.$dk.'' ?></center></td>
                  <td><center><?php echo $ticket_cek['baslik'] ?></center></td>
                  <td><center><?php 
								if ($ticket_cek['durum'] == '0'){
								echo 'Cevaplanmadı';
								}
								if ($ticket_cek['durum'] == '1'){
								echo 'Yanıtlandı';
								}
                                if ($ticket_cek['durum'] == '2'){
                                echo 'Kullanıcı Yanıtı';
                                }
                                if ($ticket_cek['durum'] == '3'){
                                echo 'Kapatıldı';
                                }
								?></center></td>
				  <td><center><a href="<?php echo "dst-goster.php/?id=".$ticket_cek['id']."/"; ?>">Göster</a><br><a href="<?php echo "dst-sil.php/?id=".$ticket_cek['id'].""; ?>">Sil</a></center></td>
                </tr>

            	
                </tbody>
              </table>
				
				<?php
						}
						}else{
						echo"<div style='color:red; width: 98%; padding-top: 20px; padding-bottom: 20px;'><center>Daha önce hiç destek bildirimi oluşturmamışsınız!</center></div>";
						}
						?>

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