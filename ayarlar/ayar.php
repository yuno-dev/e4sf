<?php

error_reporting(0);

session_start(); // ELLEMEYIN //


include('baglan.php');


// Sunucu ile ilgili bilgiler //
$sunucu_ismi = "deneme"; // Sunucu İsmini Girin //
$ip 		 = "play.deneme.org"; // Sunucu IP adresini Girin //
$surum 		 = "1.8.X"; // Sunucu Sürümünü Girin //


// Sayfa Başlığı ve Sayfa en başda duran logo //
$baslik 			= "LeaderOS v2.9"; // Sitenin Pencere bölümünde yazan yazı //
$aciklama 			= "LeaderOS v2.9"; // Google'da çıktığınızda sitenin açıklama kısmı //
$anahtar_kelimeler  = "$ip, $sunucu_ismi, minecraft, minecraft server, minecraft sunucu"; // Google'da hangi kelimeler yazılınca çıksın? // Virgül ile ayırın! //
$site_url 			= "http://ornek.com"; // Sitenizin URL'sini yazın sonunda "/" olmasın! //
$logo 				= "$site_url/img/logo.png"; // Sitenin en başında duran logo //


// Kayan yazı mesajları //
$kayan1 = "Sunucumuz yakında açılacaktır!";


date_default_timezone_set('Europe/Istanbul');

// Footer Facebook ve Youtube Linkleri //
$facebook = "facebook sayfa link"; // Facebook Sayfanızın Linki //
$youtube  = "Youtube kanal link"; // Youtube Kanal Linkiniz //


// Slider'daki resimler //

$resim1 = "$site_url/img/slider_1.png"; // Sliderda Kayan 1. Resim //
$resim2 = "$site_url/img/slider_2.png"; // Sliderda Kayan 2. Resim //
$resim3 = "$site_url/img/slider_3.png"; // Sliderda Kayan 3. Resim //
$resim4 = "$site_url/img/slider_4.png"; // Sliderda Kayan 4. Resim //


// HABERLER //

$yazi_limit = "3"; // Sayfada kaç tane haber gözüksün //

// Oyuncu İsmi çekme //

if(isset($_SESSION["uye_id"])){

	$oyuncu_id = $_SESSION["uye_id"];
	$oyuncu_cek = $db->prepare("SELECT * FROM authme WHERE id = ?");
	$oyuncu_cek->execute(array($oyuncu_id));
	$oyuncu_oku = $oyuncu_cek->fetch();
	
}


// ŞİFRELEME TÜRÜ //

$sifreleme_turu = "md5"; // SEÇENEKLER "md5" ve "sha256" //


// POST VARIABLES //

$kayit_limit        = "2";

$post_email  		= strip_tags($_POST["post_email"]);
$post_email_tekrar  = strip_tags($_POST["post_email_tekrar"]);

$post_oyuncu = strip_tags($_POST["post_oyuncu"]);

$sifre 		  = strip_tags($_POST["post_sifre"]);
$sifre_tekrar = strip_tags($_POST["post_sifre_tekrar"]);
$sifre_yeni = strip_tags($_POST["post_sifre_yeni"]);

if($sifreleme_turu == "md5"){
	$post_sifre 	 = md5($_POST["post_sifre"]);
	$post_sifre_yeni = md5($_POST["post_sifre_yeni"]);
}

if($sifreleme_turu == "sha256"){
	$post_sifre 	 = hash('sha256', $_POST['post_sifre']);
	$post_sifre_yeni = hash('sha256', $_POST['post_sifre_yeni']);
}



// BATIHOST //

$bati_host_token = "tokeniniz"; // BATIHOSTDAN ALDIĞINIZ TOKEN //
$batihost_id 	 = "müşteriid"; // BATIHOST KULLANICI ID'NIZ //
$batihost_email  = "epostanız"; // BATIHOST KULLANICI EMAIL'INIZ //


// SMTP AYARLARI //

$mail_adresi  = "mail@gmail.com"; // SMTP MAİL ADRESİNİZ //
$mail_sifre	  = "pass"; // SMTP MAİL ŞİFRENİZ //
$smtp_url	  = "smtp@gmail.com"; // SMTP SUNUCUSU //
$smtp_port	  = "587"; // SMTP SUNUCU PORTU //


// SIRALAMA //

// SEÇENEKLER: TRUE - FALSE // TRUE: GÖSTER // FALSE: GÖSTERME //

$factions_tablo = "FALSE";
$sg_tablo 		= "FALSE";
$pvp_tablo 		= "FALSE";
$skyblock_tablo = "FALSE";

// SEÇENEKLER: TRUE - FALSE // TRUE: GÖSTER // FALSE: GÖSTERME //
 
 
// SIRALAMA VERITABANI TABLOLARI //

$factions_db 			= ""; // VERITABANI TABLO ADI //
$factions_sirala 	    = "kills"; // OYUNCULAR NEYE GÖRE SIRALANSIN? // 
$factions_db_username   = "nick"; // VERITABANINDAKI OYUNCU ADI SÜTUNU //
$factions_db_kills 		= "kills"; // VERITABANINDAKI ÖLDÜRME SÜTUNU //
$factions_db_deaths 	= "deaths"; // VERITABANINDAKI ÖLME SÜTUNU //
$factions_db_ratio 		= "ratio"; // VERITABANINDAKI K/D SÜTUNU //

$sg_db 			= ""; // VERITABANI TABLO ADI //
$sg_sirala 		= "kills"; // OYUNCULAR NEYE GÖRE SIRALANSIN? // 
$sg_db_username = "nick"; // VERITABANINDAKI OYUNCU ADI SÜTUNU //
$sg_db_kills 	= "kills"; // VERITABANINDAKI ÖLDÜRME SÜTUNU //
$sg_db_deaths 	= "deaths"; // VERITABANINDAKI ÖLME SÜTUNU //
$sg_db_wins 	= "wins"; // VERITABANINDAKI K/D SÜTUNU //

$pvp_db 		 = ""; // VERITABANI TABLO ADI //
$pvp_sirala 	 = "kills"; // OYUNCULAR NEYE GÖRE SIRALANSIN? // 
$pvp_db_username = "nick"; // VERITABANINDAKI OYUNCU ADI SÜTUNU //
$pvp_db_kills 	 = "kills"; // VERITABANINDAKI ÖLDÜRME SÜTUNU //
$pvp_db_deaths 	 = "deaths"; // VERITABANINDAKI ÖLME SÜTUNU //
$pvp_db_ratio 	 = "ratio"; // VERITABANINDAKI K/D SÜTUNU //


// Token //

	class token{
		
		public function __construct(){
			
			if(!$_SESSION["spam_token"]){
				$this->tokenOlustur();
			}
			
		}
		
		public function tokenOlustur(){
			$token = strtoupper(md5(uniqid(rand(), true)));
			$_SESSION["spam_token"] = $token;
		}
		
		public function tokenSorgula($token_test){
			if($token_test == $_SESSION["spam_token"]){
				$this->tokenOlustur();
				return true;
			}
			
			return false;
		}
		
	}
	
///////////////////////////////////////

if(isset($_POST["ara"])){

	header("Location: ../profil/ara/".$_POST["post_oyuncu"]."");

}
			
?>
