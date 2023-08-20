<?php

if(file_exists('baglanti.php')){
	die("Kurulum zaten yapilmis!");
}
else{

$sifre = $_POST['sifre'];
$sifremd5 = md5($sifre);

$kadi = $_POST['ak'];

$adim = $_GET['adim'];

if ($adim == "1"){
	if ($_POST){
		
		$host = $_POST["host"];
		$username = $_POST["username"];
		$pass = $_POST["pass"];
		$veritabani = $_POST["db"];

		try {

$sql = "
CREATE TABLE `alinanurun` (
  `urun_id` int(11) NOT NULL,
  `urun_isim` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `urun_fiyat` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
";
$sql2 = "
CREATE TABLE `authme` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `lastlogin` bigint(20) DEFAULT NULL,
  `x` smallint(6) DEFAULT '0',
  `y` smallint(6) DEFAULT '0',
  `z` smallint(6) DEFAULT '0',
  `yetki` tinyint(4) NOT NULL DEFAULT '0',
  `kredi` smallint(6) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `authme` (`id`, `username`, `password`, `ip`, `lastlogin`, `x`, `y`, `z`, `yetki`, `kredi`) VALUES
(1, '$kadi', '$sifremd5', '', NULL, 0, 0, 0, 1, 0);
";
$sql3 = "
CREATE TABLE `ayar` (
  `ayar_id` int(11) NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `sunucu_ip` varchar(50) NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `sunucu_isim` varchar(200) NOT NULL,
  `websend_sayisalip` varchar(20) NOT NULL,
  `websend_sifre` varchar(100) NOT NULL,
  `websend_port` varchar(10) NOT NULL,
  `discord_davetkodu` varchar(25) NOT NULL,
  `batihost_id` varchar(10) NOT NULL,
  `batihost_email` varchar(100) NOT NULL,
  `batihost_token` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `descri` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `ayar` (`ayar_id`, `site_title`, `sunucu_ip`, `sunucu_isim`, `websend_sayisalip`, `websend_sifre`, `websend_port`, `discord_davetkodu`, `batihost_id`, `batihost_email`, `batihost_token`, `slogan`) VALUES
(0, 'Webonya Minecraft Web Scripti', 'play.webonya.com', 'Webonya v1', '127.0.0.1', 'webonya', '4445', 'discord', '0000', 'mail@mail.com', 'wbny', 'Bu bir slogan.');
";
$sql4 = "
CREATE TABLE `krediler` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `metod` varchar(10) NOT NULL,
  `miktar` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
";
$sql5 = "
CREATE TABLE `urunler` (
  `urun_id` int(11) NOT NULL,
  `urun_isim` varchar(50) NOT NULL,
  `urun_resimurl` varchar(255) NOT NULL,
  `urun_fiyat` int(11) NOT NULL,
  `urun_komut` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
";
$sql6 = "
CREATE TABLE `yazilar` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `resim` text NOT NULL,
  `yazi` text NOT NULL,
  `yazar` varchar(255) NOT NULL,
  `tarih` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yazilar` (`id`, `baslik`, `resim`, `yazi`, `yazar`, `tarih`, `kategori`) VALUES
(9, 'Webonya Test Haber', 'https://cdn1.iconfinder.com/data/icons/steaming-gaming-1/80/minecraft-block-crafting-build-512.png', 'Web siteniz başarılı bir şekilde kurulmuştur. Bu yazıyı admin panelinden (siteadresi.com/admin) silebilirsiniz.', 'Webonya', '05:24 - 23.03.2019', 'Duyuru');
";
$sql7 = "
ALTER TABLE `alinanurun`
  ADD PRIMARY KEY (`urun_id`);

ALTER TABLE `authme`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `krediler`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `urunler`
  ADD PRIMARY KEY (`urun_id`);

ALTER TABLE `yazilar`
  ADD PRIMARY KEY (`id`);
";
$sql8 = "
ALTER TABLE `alinanurun`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `authme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `krediler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `urunler`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `yazilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
";
$sql9 = "
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(255) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `mesaj` text NOT NULL,
  `durum` varchar(255) NOT NULL,
  `son_guncelleme` varchar(255) NOT NULL,
  `kanit` text NOT NULL,
  `cevap` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
$sql10 = "
CREATE TABLE IF NOT EXISTS `tickets_sc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(255) NOT NULL,
  `soru` text NOT NULL,
  `cevap` text NOT NULL,
  `ticket_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

		     $db = new PDO("mysql:host=$host;dbname=$veritabani;charset=utf8", "$username", "$pass");
		     $db->query($sql);
		     $db->query($sql2);
		     $db->query($sql3);
		     $db->query($sql4);
		     $db->query($sql5);
		     $db->query($sql6);
		     $db->query($sql7);
		     $db->query($sql8);
		     $db->query($sql9);
		     $db->query($sql10);

		} catch ( PDOException $e ){

        echo '<br><br><center><font size="6" color="red" face="Arial">MySQL Veritabanina baglanilamadi!</font></center>';

        header("refresh:2;url=install.php");

		}
		if($db){

			$olustur = touch("baglanti.php");

			if($olustur){
				$ac     = fopen('baglanti.php', 'w');
				$icerik = '
<?php

// Webonya bağlantı sayfasıdır. Dokunmayınız.

$host = "'.$host.'"; //sunucu
$kullanici = "'.$username.'"; //kullanici adi
$sifre = "'.$pass.'"; //sifre
$db = "'.$veritabani.'";//veritabani ismi 

try {
     $db = new PDO("mysql:host=$host;dbname=$db;charset=utf8", "$kullanici", "$sifre");
} catch ( PDOException $e ){
     print $e->getMessage();
}

?>
';

				$kaydet = fwrite($ac, $icerik);

				echo '<br><br><center><font size="6" color="green" face="Arial">Sistem basariyla kurulmustur!</font></center>';

        header("refresh:2;url=index.php");


			}

		}


	}else{
		header("Location: install.php");
	}
}else{

?>

<br>
<br>
<br>
<br>
<br>
<br>
<link rel="stylesheet" href="css/duyuru.css" />  
<center>

<div class="haberBaslik">
                <div class="haberBaslikYazi">Webonya Kurulum</div>
                <div class="haberBaslikTarih"> SÜRÜM : 1.0</div>
            </div>
            <div class="haberIcerik">
					<center>
					<form action="install.php?adim=1" method="post">
<table>
	<tr>
		<td>MySQL Host(Sunucu):</td>
		<td><input type="text" name="host" placeholder="Örn: localhost" /></td>
	</tr>
	<tr>
		<td>MySQL Kullanıcı Adı:</td>
		<td><input type="text" name="username" placeholder="Örn: root" /></td>
	</tr>
	<tr>
		<td>MySQL Şifre:</td>
		<td><input type="password" name="pass" /></td>
	</tr>
	<tr>
		<td>MySQL Veritabanı:</td>
		<td><input type="text" name="db"/></td>
	</tr>

	<tr>
		<td>Admin Kullanıcı Adı:</td>
		<td><input type="text" name="ak"/></td>
	</tr>
	<tr>
		<td>Admin Şifresi:</td>
		<td><input type="text" name="sifre"/></td>
	</tr>
	<tr>
		<td></td>
		<td><button type="submit" style="float: right;">Kurulumu Başlat</button></td>
	</tr>
</table>
					</form>
					</center>
				</div>
            <div class="cizgi"></div>
            <div class="haberBilgi">
                <div class="haberBilgiYazi"><i class="fa fa-pencil"></i><strong> Geliştirici: </strong>TimberLock <div class="pull-right"></div></div>
            </div>
			
			
			
</center>
</div>
<?php } } ?> 
  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/chart.min.js"></script>
  <script src="js/chart-data.js"></script>
  <script src="js/easypiechart.js"></script>
  <script src="js/easypiechart-data.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script>
    !function ($) {
      $(document).on("click","ul.nav li.parent > a > span.icon", function(){      
        $(this).find('em:first').toggleClass("glyphicon-minus");    
      }); 
      $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
      if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
      if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
  </script> 
</body>

</html>