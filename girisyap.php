
<?php
	include("Websend.php");
	include("baglanti.php");
	error_reporting(0);
	session_start();
	ob_start();

	$ayarsor=$db->prepare("SELECT * FROM ayar where ayar_id = ?");
	$ayarsor->execute(array(0));
	$ayarcek=$ayarsor->fetch();

	if($_POST){
		$kadi = $_POST["kadi"];
		$sifre = md5($_POST["sifre"]);
		$yetki = "a";
		$kullanicisor=$db->prepare("SELECT * FROM authme WHERE username=? and password=?");
		$kullanicisor->execute(array($kadi,$sifre));
		$islem=$kullanicisor->fetch();
		$yetkisor=$db->prepare("SELECT * FROM authme WHERE yetki=? and id=?");
		
		if($islem){
			$_SESSION['user_nick'] = $islem['username'];
			$_SESSION['yetki'] = $islem['yetki'];
			$_SESSION['uyeid'] = $islem['id'];
			echo "<script>alert('Giriş başarılı!')</script>";
			echo '<meta http-equiv="refresh" content="0;URL=index.php">';
			exit;
		} else{
			echo "<script>alert('Giriş bilgileri hatalı. Tekrar deneyin.')</script>";
			echo '<meta http-equiv="refresh" content="0;URL=girisyap.php">';
		} 
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Giriş Yap</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="login/images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title">
						Kullanıcı Girişi
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Boş bırakmayın">
						<input class="input100" type="text" name="kadi" placeholder="Minecraft Kullanıcı Adı">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					

					<div class="wrap-input100 validate-input" data-validate = "Boş bırakmayın">
						<input class="input100" type="password" name="sifre" placeholder="Şifre">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Giriş yap
						</button>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="kayitol.php">
							Kayıt ol
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="login/js/main.js"></script>

</body>
</html>