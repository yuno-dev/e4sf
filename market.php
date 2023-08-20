<?php 

session_start(); //session işlemini başlatıyoruz.
if(!isset($_SESSION['user_nick']))//session varmı die kontrol ediyoruz. yok ise buraya giricek
{
	header("Location:girisyap.php");//eğer session yok ise bizi giris.php gönderecek.
}
?>
<?php
include("WebsenderAPI.php");
include("baglanti.php");
error_reporting(0);
session_start();
ob_start();

include("baglanti.php");
include("meta.php");

$ayarsor=$db->prepare("SELECT * FROM ayar where ayar_id = ?");
$ayarsor->execute(array(0));
$ayarcek=$ayarsor->fetch();

$host=$ayarcek['websend_sayisalip'];
$pass=$ayarcek['websend_sifre'];
$port=$ayarcek['websend_port'];

$kullanicisor = $db->prepare("select * from authme where username=:username");
$kullanicisor->execute(array('username' => $_SESSION['user_nick']));
$kullanici = $kullanicisor->fetch(PDO::FETCH_ASSOC);

if ($_GET['ual']=="ok") {

	$urunsor=$db->prepare("SELECT * FROM urunler WHERE urun_id=:id");
	$urunsor->execute(array('id' => $_GET['uid']));
	$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);

	if ($kullanici['kredi'] >= $uruncek['urun_fiyat']) {

		$ykredi= $kullanici['kredi'] - $uruncek['urun_fiyat'];

		$duzenle=$db->prepare("UPDATE authme SET kredi=:kredi WHERE id=:id");
		$azalt=$duzenle->execute(array('kredi' => $ykredi, 'id' => $kullanici['id']));

		$ekle=$db->prepare("INSERT INTO alinanurun SET urun_isim=:urun_isim, username=:username, urun_fiyat=:urun_fiyat");
		$yeniekle=$ekle->execute(array('urun_isim' => $uruncek['urun_isim'], 'username' => $kullanici['username'], 'urun_fiyat' => $uruncek['urun_fiyat']));

		if ($yeniekle) {
            $komut=$uruncek['urun_komut'];
            $wsr = new WebsenderAPI($host,$pass,$port);

            if($wsr->connect()){
                $wsr->sendCommand(str_ireplace("%player%","".$_SESSION['user_nick']."","".$komut.""));
                echo "<script>alert('Başarıyla ürün satın alındı')</script>";
            }else{
                echo "<script>alert('Herhangi bir hata sonucu ürün verilemedi, Lütfen yetkili birine bildiriniz')</script>";
            }
            $wsr->disconnect();

			header("refresh: 0; url=profil.php");
		} else {
			echo "<script>alert('Ürün satın alınamadı')</script>";
			header("refresh: 0; url=profil.php");
		}
	}
	else
	{
		echo "<script>alert('Yetersiz kredi')</script>";
		header("refresh: 0; url=profil.php");
	}
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
					<p>Marketi görmek için sayfayı aşağı kaydırın.</p>
				</div>
			</section>

		<!-- Highlights -->
			<section class="wrapper">
				<div class="inner">
					<header class="special">
						<h2>MARKET</h2>
						<p>Market bölümüne hoşgeldin. Buradan istediğin ürünü satın alabilirsin.</p>
						<h3 style="color:red">Ürünü satın alırken oyunda olmalısınız. Aksi durumda ürün elinize ulaşmaz.</h3>
					</header>
					<div class="highlights">
						<!-------------------------
						------
						--------------------------->
					<?php
                        $market = $db->prepare("SELECT count(*) FROM urunler");
                        $market->execute();
                        $say = $market->fetchColumn();
                        if ($say==0) {?> Market'e hiç ürün eklenmemiş <?php }else{

                            $urunsor=$db->prepare("SELECT * FROM urunler order by urun_id");
                            $urunsor->execute();
                            while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) { ?>
					
					
					
						<section>
							<div class="content">
								<header>
									<img style=";<?php if ($uruncek['urun_resimurl'] == null) { echo "margin-top: 10px"; } ?>" src="<?php if( $uruncek['urun_resimurl'] != null){ echo $uruncek['urun_resimurl']; }elseif(!file_exists($uruncek['urun_resimurl'])){ echo "img/urunbos.jpg"; }?>" width="55%">
									<h2><?php echo $uruncek['urun_isim']; ?></h2>
								</header>
								<p><?php echo $uruncek['urun_fiyat']; ?> TL</p>
								<a href="market.php?uid=<?php echo $uruncek['urun_id']; ?>&ual=ok">
									<button class="btn btn-primary btn-xl" onclick="return ShowConfirm();">Ürünü al</button>
								</a>
							</div>
						</section>
						
						
						<?php
                            } 
                        }
                    ?>
						
						<!-------------------------
						------
						--------------------------->
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