<nav id="menu">
	<link rel="stylesheet" href="css/font-awesome.css" />
				<ul class="links">
					<li style="font-family: Raleway;"><a href="index.php"><i class="fa fa-home"></i>   Ana Sayfa</a></li>
					
					<?php 
					session_start();
 
					if(isset($_SESSION["user_nick"])){
					echo '<li style="font-family: Raleway;"><a href="profil.php"><i class="fa fa-user"></i>   Profil</a></li>';
					echo '<li style="font-family: Raleway;"><a href="dst.php"><i class="fa fa-ticket"></i>   Destek</a></li>';
    				echo '<li style="font-family: Raleway;"><a href="market.php"><i class="fa fa-shopping-cart"></i>   Market</a></li>';
    				echo '<li style="font-family: Raleway;"><a href="krediyukle.php"><i class="fa fa-plus-circle"></i>   Kredi Yükle</a></li>';
    				
    				echo '<li style="font-family: Raleway;"><a href="cikisyap.php"><i class="fa fa-sign-out"></i>   Çıkış Yap</a></li>';
					}else{
						echo '<li style="font-family: Raleway;"><a href="girisyap.php"><i class="fa fa-sign-in"></i>   Giriş Yap</a></li>';
						echo '<li style="font-family: Raleway;"><a href="kayitol.php"><i class="fa fa-sign-in"></i>   Kayıt Ol</a></li>';
					}
					
					?>		
				</ul>
			</nav>