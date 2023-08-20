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
				$sec = $db->prepare("SELECT * FROM tickets WHERE id = ?");
				$sec->execute(array($_GET["id"]));
				$secim = $sec->fetch();

				if($secim["nick"] == $_SESSION["user_nick"]){
				$query = $db->prepare("DELETE FROM tickets WHERE id = ? and nick = ?");
				$delete = $query->execute(array($_GET["id"],$_SESSION["user_nick"]));
				?>
                		<center>
                		<br><br><br>
                        <h1>Destek talebi başarıyla silinmiştir.</h1>
                        <h2><a href="../dst.php"><-- Geri Dön</a></h2>
                    </center>
				<?php
				}
				else{
				?>
						<center>
							<br><br><br>
                        <h1>Size ait olmayan destek bildirimlerini silemezsiniz!</h1>
                       </center>
					<?php

					}

					?>