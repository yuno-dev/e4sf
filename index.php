
<?php
if (!file_exists("baglanti.php")){
		require("install.php");
		die;
	}

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
	include ('ayar.php');
	
	$sayfa = intval($_GET["s"]);
	
	if(!$sayfa){
		$sayfa = 1;
	}
	
	$say = $db->query("SELECT * from yazilar");
	$toplamveri = $say->rowCount();
	$sayfa_sayisi = ceil($toplamveri/$yazi_limit);
	
	if($sayfa > $sayfa_sayisi){
		$sayfa = 1;
	}
	
	$goster = $sayfa * $yazi_limit - $yazi_limit;
	$gorunensayfa = 6;
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
		<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="css/duyuru.css" />
		<link rel="stylesheet" href="css/sidebar.css" />
		<link rel="stylesheet" href="css/haber.css" />
		<style type="text/css">
			.hm{
    			width: 334px;
				}
		</style>
	</head>
	<body class="is-preload">

		<!-- Header -->
			<header id="header">
				<a style="font-family: Raleway;" class="logo" href="index.php"><?php echo $ayarcek['sunucu_isim']; ?></a>
				<nav>
					<a style="font-family: Raleway;" href="#menu">Menü</a>
				</nav>
			</header>

		<!-- Nav -->
			<?php include('menu.php'); ?>

		<!-- Banner -->
			<section id="banner" >
				<div class="inner">
					<h1 style="font-family: Raleway;"><?php echo $ayarcek['sunucu_isim']; ?></h1>
					<p style="font-family: Raleway;"><?php echo $ayarcek['slogan']; ?></p>
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

<div class="Main">
        
		<div class="container" style="border-bottom: 1px solid #777; font-family: AmsiPro-Ultra">
			<div class="h2" style="font-family: Raleway;font-weight: 800;text-transform: uppercase;font-style: italic;padding-bottom: 20px;">
				Haberler
			</div>
		</div>
		<div class="container">
			<div class="Main-Articles">
			 <?php
			$duyuru_cek = $db->query("SELECT * FROM yazilar ORDER BY id DESC limit $goster,$yazi_limit");
			$duyuru_cek->execute();		
			if($duyuru_cek->rowCount() != 0){

				foreach ($duyuru_cek as $duyuru_oku) {

			?>
            <div class="haberBaslik">
                <div class="haberBaslikYazi"><?php echo $duyuru_oku['baslik'] ?></div>
                <div class="haberBaslikTarih"><?php echo $duyuru_oku['tarih'] ?></div>
            </div>
            <div class="haberIcerik">
                <img src="<?php echo $duyuru_oku['resim'] ?>" alt="<?php echo $duyuru_oku['baslik']; ?> - Haber" style="margin-left: 12px; margin-right:8px" width="149" height="150" border="0" align="left">
					<?php 
					$detay = $duyuru_oku['yazi'];
					$uzunluk = strlen($detay); 
					$limit = 500;
					if ($uzunluk > $limit) { 
					$detay = substr($detay,0,$limit) . "..."; 
					} 
					echo $detay ?>
				</div>
            <div class="cizgi"></div>
            <div class="haberBilgi">
                <div class="haberBilgiYazi"><i class="fa fa-pencil"></i><strong> Yazar: </strong><?php echo $duyuru_oku['yazar'] ?> <div class="pull-right"></div></div>
            </div>
			<?php
			}
			?>
			<?php if($sayfa > 1){ ?>
			<?php } ?>
			
			<?php
				for ($i = $sayfa - $gorunensayfa; $i < $sayfa + $gorunensayfa + 1; $i++){
					
					if($i > 0 and $i <= $sayfa_sayisi){
						
						if($i == $sayfa){
							
						?>
						
						<?php } else{ ?>
						<?php
						}
						
					}
				}
			?>
			
			<?php if($sayfa != $sayfa_sayisi){ ?>
			<?php }
			}else{
			echo'<div class="flag note note--error">
			  <div class="flag__image note__icon">
				<i class="fa fa-times"></i>
			  </div>
			  <div class="flag__body note__text">
				Yönetici tarafından henüz duyuru eklenmedi!
			  </div>
			</div>
			';
			}
			?>
                            
			</div>
			
			
			
			
			
			
            <div class="Main-Sidebar">

<?php 

session_start(); //session işlemini başlatıyoruz.
if(!isset($_SESSION['user_nick']))//session varmı die kontrol ediyoruz. yok ise buraya giricek
{ 
}else{
?>
	<section class="Main-Sidebar-Block">
		<h2 style="font-family: Ubuntu;" class="Main-Sidebar-Block-Title">HIZLI MENÜ</h2>
		<p style="font-family: Ubuntu;" class="Main-Sidebar-Block-Content">
			<center><img src="https://minotar.net/cube/<?php echo $_SESSION['user_nick']; ?>/80.png"></center>
			<center><p style="font-family: Ubuntu;">Hoşgeldin, <?php echo $_SESSION['user_nick']; ?> </p></center>
			<br>
			<button onclick="location.href = 'profil.php';" class="hm">PROFİL</button>
			<br>
			<br>
			<button onclick="location.href = 'market.php';" class="hm">MARKET</button>
			<br>
			<br>
			<button onclick="location.href = 'krediyukle.php';" class="hm">KREDİ YÜKLE</button>
			<br>
			<br>
			<button onclick="location.href = 'cikisyap.php';" class="hm">ÇIKIŞ YAP</button>
			<br>
			<br>
			<?php if ($_SESSION['yetki'] > 0){ ?>
			<button onclick="location.href = 'admin';" class="hm">ADMİN PANELİ</button>
		<?php } ?>
		</p>
	</section>
<?php } ?>

	<b><section style="font-family: Ubuntu; " class="Main-Sidebar-Block">
		<h2 class="Main-Sidebar-Block-Title"><center>SUNUCU BİLGİLERİ</center></h2>
		<center><h4 class="Main-Sidebar-Block-Content">
			Sunucu IP: <?php echo $ayarcek['sunucu_ip']; ?>
			<br><hr>
			Kayıtlı Oyuncu Sayısı: <?php
				$kayit_cek = $db->prepare("SELECT * FROM authme ORDER BY id DESC LIMIT 1");
				$kayit_cek->execute();
				$kayit_oku = $kayit_cek->fetch();
											
				if($kayit_cek->rowCount() != 0){
				echo $kayit_oku["id"];
				}
				else{
					echo "0";
				}
			?>
			<br> <hr>
<?php
//Get the status and decode the JSON
$status = json_decode(file_get_contents('https://api.mcsrvstat.us/2/'.$ayarcek['sunucu_ip'].''));

$sayioyuncu = $status->players->online;

if ($sayioyuncu > 0){
	echo 'Çevrimiçi oyuncu sayısı: '.$sayioyuncu.' ';
}else{
	echo "SUNUCU KAPALIDIR!";
}

?>
		</h4></center>
	</section></b>

	<section style="font-family: Ubuntu;" class="Main-Sidebar-Block">
		<h2 class="Main-Sidebar-Block-Title"><center>Son Alınan 3 Ürün</center></h2>
		<p class="Main-Sidebar-Block-Content">
		<table id="example2" class="table table-bordered table-hover">
                <thead>

                <tr>
                  <th>#</th>
                  <th><center>Kullanıcı adı</center></th>
                  <th><center>İsim</center></th>
                </tr>

                </thead>
                <tbody>

                <?php 
                $urunsor=$db->prepare("SELECT * FROM alinanurun order by urun_id desc limit 0, 3");
				$urunsor->execute();
				while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) {?>

                <tr>
                  <td><center><img style="border: 0px solid; border-radius: 4px;" src="https://cravatar.eu/avatar/<?php echo $uruncek['username']; ?>/24.png"></center></td>
                  <td><center><?php echo $uruncek['username']; ?></center></td>
                  <td><center><?php echo $uruncek['urun_isim']; ?> (<?php echo $uruncek['urun_fiyat']; ?>₺)</center></td>
                </tr>

            	<?php } ?>

                </tbody>
              </table>
		</p>
	</section>
	
	
	
		<section style="font-family: Ubuntu;" class="Main-Sidebar-Block">
		<h2 class="Main-Sidebar-Block-Title"><center>Son Alınan 3 Kredi</center></h2>
		<p class="Main-Sidebar-Block-Content">
		<table id="example2" class="table table-bordered table-hover">
                <thead>

                <tr>
                  <th>#</th>
                  <th><center>Kullanıcı adı</center></th>
                  <th><center>Kredi</center></th>
                  <th><center>Method</center></th>
                </tr>

                </thead>
                <tbody>

                <?php 
                $kredisor=$db->prepare("SELECT * FROM krediler order by id desc limit 0, 3");
				$kredisor->execute();
				while($kredicek=$kredisor->fetch(PDO::FETCH_ASSOC)) {?>

                <tr>
                  <td><center><img style="border: 0px solid; border-radius: 4px;" src="https://cravatar.eu/avatar/<?php echo $kredicek['username']; ?>/24.png"></center></td>
                  <td><center><?php echo $kredicek['username']; ?></center></td>
                  <td><center><?php echo $kredicek['miktar']; ?></center></td>
                  <td><center><?php echo $kredicek['metod']; ?></center></td>
                </tr>

            	<?php } ?>

                </tbody>
              </table>
		</p>
	</section>
	
</div>

		</div>





					<!------------
					--------------
					-------------->
					
					<!----------------
					------------------
					------------------
					----------------->
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