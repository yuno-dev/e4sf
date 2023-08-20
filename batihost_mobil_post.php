<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("baglanti.php");

if (!post('user')) { die("<script>window.location='$site/404';</script>"); }
if (!post('credit')) { die("<script>window.location='$site/404';</script>"); }
if (!post('guvenlik')) { die("<script>window.location='$site/404';</script>"); }

if ($_POST) {

$user = $_POST['user']; 
$miktar = $_POST['credit'];
$metod = "Mobil";
$transid = $_POST['transid'];
$telefon =  $_POST['telefon'];

	$usersor = $db->prepare("Select * from authme where username = ?");
	$usersor->execute(array($user));
	$users=$usersor->fetch();
	if($users==0)
	{
		die("Böyle bir kullanıcı kayıtlı değil");
	} 
	else 
	{
		$yeniKredi=$users['kredi'] + $miktar;
		$kredi_guncelle =  $db->prepare("UPDATE authme SET kredi=:kredi WHERE username=:username");
	    $kredi_guncelle->execute(array(
	    	'kredi' => $yeniKredi,
	    	'username' => $user));

	    $tabloya_ekle = $db->prepare("INSERT INTO krediler SET username=:nick, metod=:metod, miktar=:miktar");
		$tabloya_ekle->execute(array(
			'nick' => $user, 
			'metod' => $metod, 
			'miktar' => $miktar));

		echo 'OK';
		die();
	}
}
?>