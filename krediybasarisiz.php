<?php 

session_start(); //session işlemini başlatıyoruz.
if(!isset($_SESSION['user_nick']))//session varmı die kontrol ediyoruz. yok ise buraya giricek
{
	header("Location:girisyap.php");//eğer session yok ise bizi giris.php gönderecek.
}
?>
<?php
include("baglanti.php");
error_reporting(0);
session_start();
ob_start();

include("baglanti.php");

$ayarsor=$db->prepare("SELECT * FROM ayar where ayar_id = ?");
$ayarsor->execute(array(0));
$ayarcek=$ayarsor->fetch();

$kullanicisor = $db->prepare("select * from authme where username=:username");
$kullanicisor->execute(array('username' => $_SESSION['user_nick']));
$kullanici = $kullanicisor->fetch(PDO::FETCH_ASSOC);
?>


<html>
		<head>
			<title><?php echo $ayarcek['site_title']; ?></title>
			<meta charset="UTF-8">
		</head>
		
<body>
<center>
</br></br></br>
<img width="200" height="200" src="https://www.freeiconspng.com/uploads/red-circular-image-error-0.png">
<br>
<h1>Ödeme sırasında bir hata oluştu! Profilinize yönlendiriliyorsunuz..</h1>
<meta http-equiv="refresh" content="2;URL=profil.php">
</center>
</body>
</html>